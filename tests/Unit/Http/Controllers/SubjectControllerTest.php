<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\SubjectController;
use App\Http\Requests\SubjectRequest;
use App\Models\Course;
use App\Models\Subject;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\CourseUser\CourseUserRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\SubjectUser\SubjectUserRepositoryInterface;
use App\Repositories\Task\TaskRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Faker\Factory as Faker;
use Mockery;

class SubjectControllerTest extends TestCase
{
    protected $subjectMock;
    protected $courseMock;
    protected $subjectUserMock;
    protected $courseUserMock;
    protected $taskMock;
    protected $userMock;
    protected $faker;
    protected $subjectController;

    public function setUp(): void
    {
        $this->subjectMock = Mockery::mock(SubjectRepositoryInterface::class);
        $this->courseMock = Mockery::mock(CourseRepositoryInterface::class);
        $this->subjectUserMock = Mockery::mock(SubjectUserRepositoryInterface::class);
        $this->courseUserMock = Mockery::mock(CourseUserRepositoryInterface::class);
        $this->taskMock = Mockery::mock(TaskRepositoryInterface::class);
        $this->userMock = Mockery::mock(UserRepositoryInterface::class);
        $this->subjectController = new SubjectController(
            $this->subjectMock,
            $this->courseMock,
            $this->subjectUserMock,
            $this->courseUserMock,
            $this->taskMock,
            $this->userMock
        );
        parent::setUp();
    }

    public function tearDown(): void
    {
        unset($this->subjectController);
        Mockery::close();
        parent::tearDown();
    }

    public function test_index_function()
    {
        $this->courseMock
            ->shouldReceive('getAll')
            ->with([
                'subjects',
                'subjects.subjectUsers',
            ])
            ->once()
            ->andReturn(new Collection);
        $this->subjectMock
            ->shouldReceive('getAll')
            ->once()
            ->andReturn(new Collection);
        $result = $this->subjectController->index();
        $data = $result->getData();
        $this->assertIsArray($data);
        $this->assertEquals('supervisor.manage-subject.list-subjects', $result->getName());
        $this->assertArrayHasKey('courses', $data);
        $this->assertArrayHasKey('subjects', $data);
    }

    public function test_store_function()
    {
        $path = 'public/images/download.png';
        $mimeType = 'image/png';
        $originalName = 'download.png';
        $error = config('number.empty');
        $this->faker = Faker::create();
        $data = [
            'title' => 'test',
            'image' => new UploadedFile($path, $originalName, $mimeType, $error),
            'content_description' => $this->faker->text,
            'time' => config('number.time_default'),
            'course_id' => config('number.init'),
        ];
        $subject = new Subject();
        $subject->id = config('number.init');
        $this->subjectMock
            ->shouldReceive('create')
            ->once()
            ->andReturn($subject);
        $request = new SubjectRequest($data);
        $result = $this->subjectController->store($request);
        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(
            route('subject.show', ['subject' => $subject->id]),
            $result->headers->get('Location')
        );
    }

    public function test_update_function()
    {
        $path = 'public/images/download.png';
        $mimeType = 'image/png';
        $originalName = 'download.png';
        $error = config('number.empty');
        $this->faker = Faker::create();
        $id = config('number.init');
        $data = [
            'id' => config('number.init'),
            'title' => 'test',
            'image' => new UploadedFile($path, $originalName, $mimeType, $error),
            'content_description' => $this->faker->text,
            'time' => config('number.time_default'),
            'course_id' => config('number.init'),
        ];
        $subject = new Subject();
        $subject->id = config('number.init');
        $this->subjectMock
            ->shouldReceive('update')
            ->once()
            ->andReturn(true);
        $request = new SubjectRequest($data);
        $result = $this->subjectController->update($request, $id);
        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(
            route('subject.show', ['subject' => $subject->id]),
            $result->headers->get('Location')
        );
    }

    public function test_update_function_fail()
    {
        $path = 'public/images/download.png';
        $mimeType = 'image/png';
        $originalName = 'download.png';
        $error = config('number.empty');
        $this->faker = Faker::create();
        $id = config('number.init');
        $data = [
            'id' => config('number.init'),
            'title' => 'test',
            'image' => new UploadedFile($path, $originalName, $mimeType, $error),
            'content_description' => $this->faker->text,
            'time' => config('number.time_default'),
            'course_id' => config('number.init'),
        ];
        $subject = new Subject();
        $subject->id = config('number.init');
        $this->subjectMock
            ->shouldReceive('update')
            ->once()
            ->andThrow(new ModelNotFoundException);
        $request = new SubjectRequest($data);
        $result = $this->subjectController->update($request, $id);
        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(
            route('subject.show', ['subject' => $subject->id]),
            $result->headers->get('Location')
        );
        $this->assertArrayHasKey('error', $result->getSession()->all());
    }

    public function test_destroy_function()
    {
        $subject = new Subject();
        $course = new Course();
        $course->id = config('number.test.id');
        $this->subjectMock
            ->shouldReceive('getById')
            ->with(config('number.test.id'))
            ->once()
            ->andReturn($subject);
        $this->subjectMock
            ->shouldReceive('getCourseBySubject')
            ->with($subject)
            ->once()
            ->andReturn($course);

        $this->subjectUserMock
            ->shouldReceive('deleteWhereEqual')
            ->with(['subject_id' => config('number.test.id')])
            ->once()
            ->andReturn(true);

        $this->taskMock
            ->shouldReceive('deleteWhereEqual')
            ->with(['subject_id' => config('number.test.id')])
            ->once()
            ->andReturn(true);

        $this->subjectMock
            ->shouldReceive('delete')
            ->with(config('number.test.id'))
            ->once()
            ->andReturn(true);

        $courseUsers = new Collection();
        $this->courseUserMock
            ->shouldReceive('getWhereEqual')
            ->with([
                'course_id' => config('number.test.id'),
            ], 'user')
            ->once()
            ->andReturn($courseUsers);
        $subjects = new Collection(
            [
                new Subject(),
            ]
        );
        $this->courseMock
            ->shouldReceive('getSubjectsByCourse')
            ->with($course)
            ->once()
            ->andReturn($subjects);

        $result = $this->subjectController->destroy(config('number.test.id'));
        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(
            route('subject.index'),
            $result->headers->get('Location')
        );
        $this->assertArrayHasKey('messenger', $result->getSession()->all());
    }

    public function test_destroy_function_fail()
    {
        $this->subjectMock
            ->shouldReceive('getById')
            ->with(config('number.test.id'))
            ->once()
            ->andThrow(new ModelNotFoundException);
        $result = $this->subjectController->destroy(config('number.test.id'));
        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(
            route('subject.index'),
            $result->headers->get('Location')
        );
        $this->assertArrayHasKey('error', $result->getSession()->all());
    }
}
