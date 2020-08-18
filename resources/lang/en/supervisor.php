<?php

return [
    'app' => [
        'dashboard' => 'Dashboard',
        'course' => 'Course',
        'subject' => 'Subject',
        'task' => 'Task',
        'user' => 'User',
        'trainee' => 'Trainee',
        'supervisor' => 'Supervisor',
        'main' => 'Main',
        'menu' => 'Menu',
        'search_components' => 'Search components...',
        'setting' => 'Setting',
        'color' => 'Color',
        'language' => 'Language',
        'fullname' => 'Thao kute',
        'profile' => 'Profile',
        'account_settings' => 'Account Settings',
        'sign_out' => 'Sign out',
        'message' => 'Message',
        'notification' => 'Notification',
        'days' => 'days',
        'message_active_course' => 'Do you want to trainee active this course?',
    ],
    'list_courses' => [
        'list_courses' => 'List Courses',
        'id' => 'ID',
        'image' => 'Image',
        'title' => 'Title',
        'subjects' => 'Subjects',
        'attending' => 'Trainees attending',
        'see' => 'See Detail',
        'edit' => 'Edit',
        'delete' => 'Delete item',
        'previous' => 'Previous',
        'next' => 'Next',
    ],
    'create_course' => [
        'new_course' => 'New Course',
        'title' => 'Title',
        'image' => 'Image',
        'description' => 'Description',
        'submit' => 'Submit',
    ],
    'edit_course' => [
        'edit_course' => 'Edit Course',
        'title' => 'Title',
        'image' => 'Image',
        'description' => 'Description',
        'submit' => 'Submit',
    ],
    'detail_course' => [
        'detail_course' => 'Detail Course',
        'list_subjects' =>  'List Subjects',
        'list_trainees' => 'List Trainees Attending',
        'message_delete' => 'Do you want to delete this course?',
    ],
    'list_subjects' => [
        'list_subjects' => 'List Subjects',
        'id' => 'ID',
        'image' => 'Image',
        'title' => 'Title',
        'course' => 'course',
        'time' => 'Estimated Time',
        'attending' => 'Trainees attending',
        'see' => 'See Detail',
        'edit' => 'Edit',
        'delete' => 'Delete item',
        'previous' => 'Previous',
        'next' => 'Next',
        'group' => 'Groups',
        'all' => 'All',
    ],
    'create_subject' => [
        'new_subject' => 'New Subject',
        'title' => 'Title',
        'image' => 'Image',
        'time' => 'Estimated Time',
        'course' => 'Course',
        'description' => 'Description',
        'submit' => 'Submit',
    ],
    'edit_subject' => [
        'edit_subject' => 'Edit Subject',
        'submit' => 'Submit',
    ],
    'detail_subject' => [
        'detail_subject' => 'Detail Subject',
        'list_tasks' =>  'List Tasks Of Today',
        'list_trainees' => 'List Trainees Attending',
        'message_delete' => 'Do you want to delete this subject?',
        'workdays' => 'workdays',
        'message_pass' => 'Do you want to pass subject for this user?',
    ],
    'list_tasks' => [
        'id' => 'ID',
        'created_at' => 'Created at',
        'subject'  => 'Subject',
        'trainee' => 'Trainee',
        'status' => 'Status',
    ],
    'detail_task' => [
        'detail_task' => 'Detail Task',
        'new' => 'New',
        'passed' => 'Passed',
        'failed' => 'Failed',
        'date' => 'Date',
        'subject' => 'Subject',
        'trainee' => 'Trainee',
        'plan' => 'Plan',
        'actual' => 'Actual',
        'next_plan' => 'Next Plan',
        'comment' => 'Comment',
        'review' => 'Review',
        'fail' => 'Fail',
        'pass' => 'Pass',
    ],
    'list_trainees' => [
        'avatar' => 'Avatar',
        'id' => 'ID',
        'fullname' => 'Fullname',
        'email' => 'Email',
        'status' => 'Status',
        'birthday' => 'Birthday',
        'new_trainee' => 'New Trainee',
        'assign' => 'Assign',
    ],
    'detail_user' => [
        'detail_trainee' => 'Detail Trainee',
        'detail_supervisor' => 'Detail Supervisor',
        'active' => 'Active',
        'inactive' => 'Inactive',
        'email' => 'Email',
        'birthday' => 'Birthday',
        'gender' => 'Gender',
        'progress' => 'Progress',
        'reset_password' => 'Reset Password',
        'lock_account' => 'Lock Account',
        'unlock_account' => 'UnLock Account',
        'message_reset' => 'Do you want to reset password of this trainee?',
        'message_lock' => 'Do you want to lock account of this trainee?',
        'message_unlock' => 'Do you want to unlock account of this trainee?',
        'course_inactive' => 'List Course InActive',
        'reset_success' => 'Password is reseted',
        'lock_success' => 'Account is locked',
        'unlock_success' => 'Account is unlocked',
    ],
    'new_trainee' => [
        'new_trainee' => 'New Trainee',
        'fullname' => 'Fullname',
        'email' => 'Email',
        'birthday' => 'Birthday',
        'gender' => 'Gender',
        'male' => 'Male',
        'female' => 'Female',
        'submit' => 'Submit',
        'password' => 'Password',
        'default' => 'Default: "password"',
    ],
    'assign' => [
        'assign' => 'ASSIGN',
        'course' => 'Course',
        'subject' => 'Subject',
        'trainee' => 'Trainee',
    ],
    'request' => [
        'image_type' => 'Please upload an image',
        'image_required' => 'image field is required',
        'image_large' => 'File too large, choose smaller than this file',
        'title_large' => 'Title to large, choose smaller than this title',
        'description_required' => 'Description field is required',
        'time_required' => 'Time field is required',
        'time_min' => 'Time too small, choose bigger than this time',
    ],
];
