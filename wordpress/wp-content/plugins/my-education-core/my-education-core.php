<?php
/*
Plugin Name: My Education Core
Description: The engine for my custom Education Site. Creates Courses, Lessons, and Subjects.
Version: 1.0
Author: Hunter
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// 1. Function to create the "COURSE" Post Type
function my_education_register_course() {
    $labels = array(
        'name'               => 'Courses',
        'singular_name'      => 'Course',
        'add_new'            => 'Add New Course',
        'add_new_item'       => 'Add New Course',
        'edit_item'          => 'Edit Course',
        'new_item'           => 'New Course',
        'all_items'          => 'All Courses',
        'view_item'          => 'View Course',
        'search_items'       => 'Search Courses',
        'not_found'          => 'No courses found',
        'menu_name'          => 'Courses'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'course' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-welcome-learn-more', // Graduation Cap Icon
        'show_in_rest'       => true, // Enables the modern Block Editor (Gutenberg)
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' )
    );

    register_post_type( 'course', $args );
}
add_action( 'init', 'my_education_register_course' );


// 2. Function to create the "LESSON" Post Type
function my_education_register_lesson() {
    $labels = array(
        'name'               => 'Lessons',
        'singular_name'      => 'Lesson',
        'menu_name'          => 'Lessons'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => 'edit.php?post_type=course', // This tucks "Lessons" inside the "Courses" menu!
        'rewrite'            => array( 'slug' => 'lesson' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'show_in_rest'       => true,
        'supports'           => array( 'title', 'editor', 'page-attributes' ) // Page attributes allow ordering (1, 2, 3)
    );

    register_post_type( 'lesson', $args );
}
add_action( 'init', 'my_education_register_lesson' );


// 3. Function to create "SUBJECTS" (Categories for Courses)
function my_education_register_subject() {
    $labels = array(
        'name'              => 'Subjects',
        'singular_name'     => 'Subject',
        'search_items'      => 'Search Subjects',
        'all_items'         => 'All Subjects',
        'edit_item'         => 'Edit Subject',
        'update_item'       => 'Update Subject',
        'add_new_item'      => 'Add New Subject',
        'menu_name'         => 'Subjects',
    );

    $args = array(
        'hierarchical'      => true, // True means it works like Categories (Parent/Child)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'subject' ),
        'show_in_rest'      => true,
    );

    register_taxonomy( 'subject', array( 'course' ), $args );
}
add_action( 'init', 'my_education_register_subject' );
?>