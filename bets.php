<?php
/**
 * Created by PhpStorm.
 * Date:        23.08.2018
 * Time:        13:49
 * Plugin Name: BetsPlugin
 * Author URI:  http://github.com/kacevnik
 * Author:      Dvitriy Kovalev
 * Version:     1.0
 *
 */

global $wp_version;
$min_version_wp = '4.7';

if(version_compare($wp_version, $min_version_wp, '<')){
    function com_version_wp($var){
        if($var){
            ?>
                <div class="notice notice-error">
                    <p>Внимание минимальная версия Wordpress для плагина BetsPlugin - <b><?=$var?></b>! Обновите WordPress!</p>
                </div>
            <?php
        }
    }
    add_action('admin_notices', 'com_version_wp');
    do_action('admin_notices', $min_version_wp);
}else{

    add_action('init', 'create_taxonomy_type_bets');
    function create_taxonomy_type_bets(){
        register_taxonomy('type_bets', array('post_bets'), array(
            'label'                 => 'type bet',
            'labels'                => array(
                'name' => _x( 'Типы Ставок', 'type bets' ),
                'singular_name' => _x( 'Тип Ставки', 'type bet' ),
                'search_items' =>  __( 'Искать тип ставки' ),
                'all_items' => __( 'Все типы ставок' ),
                'parent_item' => __( 'Родительский тип ставки' ),
                'parent_item_colon' => __( 'Родительский тип ставки:' ),
                'edit_item' => __( 'Редактировать тип ставки' ),
                'update_item' => __( 'Обновить тип ставки' ),
                'add_new_item' => __( 'Добавить тип ставки' ),
                'new_item_name' => __( 'Новый тип ставки' ),
                'menu_name' => __( 'Типы ставок' ),
            ),
            'description'           => '',
            'public'                => true,
            'publicly_queryable'    => null,
            'show_in_nav_menus'     => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'show_tagcloud'         => true,
            'show_in_rest'          => null,
            'rest_base'             => null,
            'hierarchical'          => true,
            'update_count_callback' => '',
            'rewrite'               => true,
            'capabilities'          => array(),
            'meta_box_cb'           => null,
            'show_admin_column'     => false,
            '_builtin'              => false,
            'show_in_quick_edit'    => null
        ) );
    }

    add_action('init', 'create_taxonomy_status_bets');
    function create_taxonomy_status_bets(){
        register_taxonomy('status_bets', array('post_bets'), array(
            'label'                 => 'status bet',
            'labels'                => array(
                'name' => _x( 'Статусы ставок', 'status bets' ),
                'singular_name' => _x( 'Статус ставки', 'single status bet' ),
                'search_items' =>  __( 'Искать статус ставки' ),
                'all_items' => __( 'Все статусы ставок' ),
                'parent_item' => __( 'Родительский статус ставки' ),
                'parent_item_colon' => __( 'Родительский статус ставки:' ),
                'edit_item' => __( 'Редактировать статус ставки' ),
                'update_item' => __( 'Обновить статус ставки' ),
                'add_new_item' => __( 'Добавить статус ставки' ),
                'new_item_name' => __( 'Новый статус ставки' ),
                'menu_name' => __( 'Статусы ставок' ),
            ),
            'description'           => '',
            'public'                => true,
            'publicly_queryable'    => null,
            'show_in_nav_menus'     => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'show_tagcloud'         => true,
            'show_in_rest'          => null,
            'rest_base'             => null,
            'hierarchical'          => true,
            'update_count_callback' => '',
            'rewrite'               => true,
            'capabilities'          => array(),
            'meta_box_cb'           => null,
            'show_admin_column'     => false,
            '_builtin'              => false,
            'show_in_quick_edit'    => null
        ) );
    }



    add_action( 'init', 'register_post_bets' );
    function register_post_bets(){
        register_post_type('bets', array(
            'label'  => post_bets,
            'labels' => array(
                'name'               => 'Ставки',
                'singular_name'      => 'Ставка',
                'add_new'            => 'Добавить ставку',
                'add_new_item'       => 'Добавление ставки',
                'edit_item'          => 'Редактирование ставки',
                'new_item'           => 'Новая ставка',
                'view_item'          => 'Смотреть ставку',
                'search_items'       => 'Искать ставку',
                'not_found'          => 'Не найдено ставок',
                'not_found_in_trash' => 'Не найдено в корзине ставок',
                'parent_item_colon'  => '',
                'menu_name'          => 'Ставки',
            ),
            'description'         => '',
            'public'              => true,
            'publicly_queryable'  => null,
            'exclude_from_search' => null,
            'show_ui'             => null,
            'show_in_menu'        => null,
            'show_in_admin_bar'   => null,
            'show_in_nav_menus'   => null,
            'show_in_rest'        => null,
            'rest_base'           => null,
            'menu_position'       => null,
            'menu_icon'           => 'dashicons-carrot',
            'hierarchical'        => false,
            'supports'            => array('title','editor'),
            'taxonomies'          => array('type_bets', 'status_bets'),
            'has_archive'         => false,
            'rewrite'             => true,
            'query_var'           => true,
        ) );
    }

    add_action('init', 'add_custom_term');

    function add_custom_term(){
        global $wpdb;
        $custom_array_terms = ['0' => array('name' => 'ординар', 'slug'  => 'ordinar', 'taxonomy'   => 'type_bets'),
            '1' => array('name' => 'экспресс', 'slug' => 'exspress', 'taxonomy'  => 'type_bets'),
            '2' => array('name' => 'выигрыш', 'slug'  => 'win_bet', 'taxonomy'   => 'status_bets'),
            '3' => array('name' => 'проигрыш', 'slug' => 'lose_bet', 'taxonomy'  => 'status_bets'),
            '4' => array('name' => 'возврат', 'slug'  => 'back_bet', 'taxonomy'  => 'status_bets'),
            '5' => array('name' => 'активная', 'slug' => 'activ_bet', 'taxonomy' => 'status_bets')
        ];
        foreach ($custom_array_terms as $custom_array_terms_item){
            $terms = term_exists($custom_array_terms_item['slug'], $custom_array_terms_item['taxonomy']);

            if(!count($terms)){
                $insert_term = wp_insert_term($custom_array_terms_item['name'], $custom_array_terms_item['taxonomy'],
                    array(
                        'description' => '',
                        'slug'        => $custom_array_terms_item['slug']
                    )
                );
            }
        }
    }

    add_action('init', 'add_custom_rolls');

    function add_custom_rolls(){
        $add_capper = add_role( 'capper', 'Каппер',
            array(
                'read'         => true,
                'publish_posts' => true,
                'edit_posts' => true
            )
        );

        $add_moderator = add_role( 'moderator', 'Модератор',
            array(
                'read'         => true,
                'edit_others_posts' =>true,
                'publish_posts' => true,
                'edit_posts' => true,
                'edit_private_posts' => true
            )
        );

    }

}



