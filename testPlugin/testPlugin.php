<?php
/*
 * Plugin Name: Test Plugin
 * Plugin URI:fd
 * Description: Description
 * Version: 1
 * Author: alex
 * Author URI: https://alex.blog

 */

function al_custom_post() {
 
  // Set the labels, this variable is used in the $args array
  $labels = array(
    'name'               => __( 'Bets' ),
    'singular_name'      => __( 'Bet' ),
    'add_new'            => __( 'Add New Bet' ),
    'add_new_item'       => __( 'Add New Bet' ),
    'edit_item'          => __( 'Edit Bet' ),
    'new_item'           => __( 'New Bet' ),
    'all_items'          => __( 'All Bet' ),
    'view_item'          => __( 'View Bets' ),
    'search_items'       => __( 'Search Bets' ),
    'featured_image'     => 'Poster',
    'set_featured_image' => 'Add Poster'
  );
 
  // The arguments for our post type, to be entered as parameter 2 of register_post_type()
  $args = array(
    'labels'            => $labels,
    'description'       => 'Description about bets',
    'public'            => true,
    'menu_position'     => 5,
    'supports'          => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
    'has_archive'       => true,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'has_archive'       => true,
    'query_var'         => 'Bet',
    'capabilities' => array(
      'edit_post' => 'edit_bet_content',
      'edit_posts' => 'edit_bet_contents',
      'edit_published_posts' => 'edit_published_bet_contents',
      'edit_others_posts' => 'edit_other_bet_content',
      'publish_posts' => 'publish_bet_content',
      'read_post' => 'read_bet_content',
      'read_private_posts' => 'read_private_bet_content',
      'delete_post' => 'delete_bet_content',
      'delete_posts' => 'delete_bet_contents',
      'delete_published_posts' => 'delete_published_bet_contents'
    ),
  );
 
  // Call the actual WordPress function
  // Parameter 1 is a name for the post type
  // Parameter 2 is the $args array
  register_post_type( 'bet', $args);
}

// Hook <strong>lc_custom_post_movie()</strong> to the init action hook
add_action( 'init', 'al_custom_post' );
 
// The custom function to register a movie post type

 


//Добавляем Таксономию тип ставки "type_bet"

add_action( 'init', 'create_topics_nonhierarchical_taxonomy', 0 );

function create_topics_nonhierarchical_taxonomy() {

// Задаем названия для интерфейса

  $labels = array(
    'name' => _x( 'Типы ставок', 'taxonomy general name' ),
    'singular_name' => _x( 'Тип ставки', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Topics' ),
    'popular_items' => __( 'Popular Topics' ),
    'all_items' => __( 'All Bets' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit type bet' ),
    'update_item' => __( 'Update type bet' ),
    'add_new_item' => __( 'Добавить новый тип ставки' ),
    'new_item_name' => __( 'New type Name' ),
    'separate_items_with_commas' => __( 'Separate bet with commas' ),
    'add_or_remove_items' => __( 'Add or remove topics' ),
    'choose_from_most_used' => __( 'Choose from the most used topics' ),
    'menu_name' => __( 'Тип ставки' ),
  );

// Теперь регистрируем НЕ-иерархическую таксономию

  register_taxonomy('type_bet','bet',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'type bet' ),
  ));
}



register_activation_hook( __FILE__, 'add_roles_on_plugin_activation' );
function add_roles_on_plugin_activation() {
  //Добавляем роль капер
    $result = add_role( 'caper', 'Капер',
    array(
      'read'         => true,  // true разрешает эту возможность

        )
    );
  if ( null !== $result ) {
    echo 'Ура! Новая роль создана!';
  }
  else {
    echo 'Ой... Такая роль уже существует.';
  }

//Добавляем роль модератор
  $result1 = add_role( 'moderator', 'Модератор',
    array(
      'read'         => true,  // true разрешает эту возможность

        )
    );
  if ( null !== $result1 ) {
    echo 'Ура! Новая роль создана!';
  }
  else {
    echo 'Ой... Такая роль уже существует.';
  }

// Добавляем права для роли Капер
  $caper = get_role('caper');
  $caper->add_cap('edit_bet_content');
  $caper->add_cap('edit_bet_contents');
  $caper->add_cap('read_bet_content');
  $caper->add_cap('delete_bet_content');
  $caper->add_cap('delete_bet_contents');
  $caper->add_cap('edit_published_bet_contents');
  $caper->add_cap('delete_published_bet_contents');



// Добавляем права для роли Администратор
  $admin = get_role('administrator');
  $admin->add_cap('edit_bet_content');
  $admin->add_cap('edit_bet_contents');
  $admin->add_cap('edit_other_bet_content');

  $admin->add_cap('read_bet_content');
  $admin->add_cap('delete_bet_content');
  $admin->add_cap('delete_bet_contents');
  $admin->add_cap('edit_published_bet_contents');
  $admin->add_cap('delete_published_bet_contents');


// Добавляем права для Модератора 
  $moderator = get_role('moderator');
  $moderator->add_cap('edit_bet_content');
  $moderator->add_cap('edit_bet_contents');
  $moderator->add_cap('edit_other_bet_content');
  $moderator->add_cap('read_bet_content');
  $moderator->add_cap('delete_bet_content');
  $moderator->add_cap('delete_bet_contents');
  $moderator->add_cap('edit_published_bet_contents');
  $moderator->add_cap('delete_published_bet_contents');

}


register_deactivation_hook( __FILE__, 'myplugin_deactivate' );
function myplugin_deactivate(){
  remove_role( 'caper' );
  remove_role( 'moderator' );
}