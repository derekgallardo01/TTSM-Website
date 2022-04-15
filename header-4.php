<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html id="sm_html" <?php language_attributes(); ?>>
<!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width" />
        <title><?php
            /*
             * Print the <title> tag based on what is being viewed.
             */
            global $page, $paged;
            
            wp_title( '|', true, 'right' );
            
            // Add the blog name.
            bloginfo( 'name' );
            
            // Add the blog description for the home/front page.
            $site_description = get_bloginfo( 'description', 'display' );
            if ( $site_description && ( is_home() || is_front_page() ) )
            	echo " | $site_description";
            
            // Add a page number if necessary:
            if ( $paged >= 2 || $page >= 2 )
            	echo ' | ' . sprintf( __( 'Page %s', 'spotmassage' ), max( $paged, $page ) );
            
        ?></title>
        <link rel="stylesheet" type="text/css" media="all" href="http://fonts.googleapis.com/css?family=Josefin+Sans" />
        <link rel="stylesheet" type="text/css" media="all" href="http://fonts.googleapis.com/css?family=Quicksand" />
        <link rel="stylesheet" type="text/css" media="all" href="http://fonts.googleapis.com/css?family=Open+Sans" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri().'/fonts/dimbo.css'; ?>" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/normalize.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/base.css" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

        <!--[if IE 7]>
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/ie7.css" />
        <![endif]-->
        <!--[if IE 8]>
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/ie8.css" />
        <![endif]-->
        <?php wp_head(); ?>
    </head>
    <body id="sm_body" <?php body_class(); ?>>
        <div id="header">
            <div class="total-width">
                <?php $header_image = get_header_image(); ?>
                <?php if( $header_image ): $custom_header = get_custom_header(); ?>
                    <div id="logo">
                        <a href="<?php echo site_url(); ?>">
                            <img src="<?php header_image(); ?>" height="<?php echo $custom_header->height; ?>" width="<?php echo $custom_header->width; ?>" 
                                alt="lo" />
                        </a>
                    </div>
                <?php else: ?>
                    <div id="logo-text">
                        <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>
                    </div>
                <?php endif; ?>
                <div class="right-header">
                    <div id="menu-header"><?php wp_nav_menu( array( 'theme_location' => 'header-menu-4','menu_class' => 'menu','container_class' => 'sm-menu','menu_id' => 'nav-header-menu' ) ); ?></div>
                    <?php if(is_active_sidebar('sidebar-header')): ?>
                        <div class="sidebar-header"><?php dynamic_sidebar('sidebar-header'); ?></div>
                    <?php endif; ?>
                </div>
            </div>
          <!--  <div id="wrapper-main-menu">
                <div id="main-menu" class="total-width">
                    
                </div>
            </div> -->
        </div>