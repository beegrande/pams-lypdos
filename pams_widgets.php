<?php
/*
 */

class RelatedPostWidget extends WP_Widget {

    function RelatedPostWidget() {
        $widget_ops = array( 'classname' => 'RelatedPostWidget', 'description' => 'Displays related posts based on tags for post types: POST, SERVICE, CTRL_DOC, DEFINITION.' );
        $this->WP_Widget( 'RelatedPostWidget', 'Related Posts', $widget_ops );
    }

    function form( $instance ) {
        $instance = wp_parse_args( ( array ) $instance, array( 'title' => 'Related posts' ) );
        $title = $instance[ 'title' ];
        ?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo attribute_escape( $title ); ?>" /></label></p>
        <?php
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance[ 'title' ] = $new_instance[ 'title' ];
        return $instance;
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );

        echo $before_widget;
        $title = empty( $instance[ 'title' ] ) ? ' ' : apply_filters( 'widget_title', $instance[ 'title' ] );

        if ( !empty( $title ) )
            echo $before_title . $title . $after_title;;

        // WIDGET CODE GOES HERE
        $before = '<ul class="sidebar-list">';
        $sep1 = '<li>';
        $sep2 = '</li>';
        $after = '</ul>';
        $post = NULL;
        $orig_post = $post;
        global $post;
        $tags = wp_get_post_tags( $post->ID );

        if ( $tags ) {
            $tag_ids = array();
            foreach ( $tags as $individual_tag )
                $tag_ids[] = $individual_tag->term_id;
            $args = array(
                'tag__in' => $tag_ids,
                'post__not_in' => array( $post->ID ),
                'post_type' => array( 'post', 'service', 'definition', 'ctrl_doc' ),
                'posts_per_page' => 15, // Number of related posts to display.
                'ignore_sticky_posts' => 1,
                'orderby' => 'name'
            );

            $my_query = new wp_query( $args );
            if ( $before )
                echo $before;
            while ( $my_query->have_posts() ) {
                $my_query->the_post();
                echo $sep1;
                ?><a rel="external" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                        <?php
                        echo $sep2;
                    } echo $after;
                }
                $post = $orig_post;
                wp_reset_query();
                echo $after_widget;
            }

        }

        add_action( 'widgets_init', create_function( '', 'return register_widget("RelatedPostWidget");' ) );

        class TargetGroupWidget extends WP_Widget {

            function TargetGroupWidget() {
                $widget_ops = array( 'classname' => 'TargetGroupWidget', 'description' => 'Displays who should read based on target group tags.' );
                $this->WP_Widget( 'TargetGroupWidget', 'Who should read', $widget_ops );
            }

            function form( $instance ) {
                $instance = wp_parse_args( ( array ) $instance, array( 'title' => 'Who should read' ) );
                $title = $instance[ 'title' ];
                ?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo attribute_escape( $title ); ?>" /></label></p>
        <?php
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance[ 'title' ] = $new_instance[ 'title' ];
        return $instance;
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );

        echo $before_widget;
        $title = empty( $instance[ 'title' ] ) ? ' ' : apply_filters( 'widget_title', $instance[ 'title' ] );

        if ( !empty( $title ) )
            echo $before_title . $title . $after_title;;

        // WIDGET CODE GOES HERE
        if ( !$post_type == 'definition' ) {
            $before = '<ul class="sidebar-list"><li>';
            $sep = '</li><li>';
            $after = '</li></ul>';
            the_targetgroups( $before, $sep, $after, $post->$id );
        }
        echo $after_widget;
    }

}

add_action( 'widgets_init', create_function( '', 'return register_widget("TargetGroupWidget");' ) );

class StakeholdersWidget extends WP_Widget {

    function StakeholdersWidget() {
        $widget_ops = array( 'classname' => 'StakeholdersWidget', 'description' => 'Displays stakeholders CTRL_DOCS.' );
        $this->WP_Widget( 'StakeholdersWidget', 'Stakeholders', $widget_ops );
    }

    function form( $instance ) {
        $instance = wp_parse_args( ( array ) $instance, array( 'title' => 'Stakeholders' ) );
        $title = $instance[ 'title' ];
        echo ( '<p><label for="' . $this->get_field_id( 'title' ) . '">Title: <input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . attribute_escape( $title ) . '" /></label></p>' );
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance[ 'title' ] = $new_instance[ 'title' ];
        return $instance;
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        if ( get_option( 'pms_lypdos_ctrl_doc_show_stakeholders' ) == 'enabled' ) {
            echo $before_widget;
            $title = empty( $instance[ 'title' ] ) ? ' ' : apply_filters( 'widget_title', $instance[ 'title' ] );

            if ( !empty( $title ) )
                echo $before_title . $title . $after_title;;

            // WIDGET CODE GOES HERE
            echo ( get_stakeholders( '<ul class="sidebar-list">', '<li>', '</li>', '<br>', '</ul>' ) );
            echo $after_widget;
        }
    }

}

add_action( 'widgets_init', create_function( '', 'return register_widget("StakeholdersWidget");' ) );

class DependingServicesWidget extends WP_Widget {

    function DependingServicesWidget() {
        $widget_ops = array( 'classname' => 'DependingServicesWidget', 'description' => 'Displays services that depend on current service.' );
        $this->WP_Widget( 'DependingServicesWidget', 'Depending services', $widget_ops );
    }

    function form( $instance ) {
        $instance = wp_parse_args( ( array ) $instance, array( 'title' => 'Depending services' ) );
        $title = $instance[ 'title' ];
        echo ( '<p><label for="' . $this->get_field_id( 'title' ) . '">Title: <input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . attribute_escape( $title ) . '" /></label></p>' );
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance[ 'title' ] = $new_instance[ 'title' ];
        return $instance;
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        if ( get_option( 'pms_lypdos_service_show_depending_services' ) == 'enabled' ) {
            echo $before_widget;
            $title = empty( $instance[ 'title' ] ) ? ' ' : apply_filters( 'widget_title', $instance[ 'title' ] );

            if ( !empty( $title ) )
                echo $before_title . $title . $after_title;;

            // WIDGET CODE GOES HERE
            echo ( get_depending_services( '', 'true' ) );
            echo $after_widget;
        }
    }

}

add_action( 'widgets_init', create_function( '', 'return register_widget("DependingServicesWidget");' ) );

class PamsRecentPostsWidget extends WP_Widget {

    function PamsRecentPostsWidget() {
        $widget_ops = array( 'classname' => 'PamsRecentPostsWidget', 'description' => 'Displays recent Ctrl_docs, Services and Definitions.' );
        $this->WP_Widget( 'PamsRecentPostsWidget', 'Recent posts', $widget_ops );
    }

    function form( $instance ) {
        $instance = wp_parse_args( ( array ) $instance, array( 'title' => 'Recent posts' ) );
        $title = $instance[ 'title' ];
        echo ( '<p><label for="' . $this->get_field_id( 'title' ) . '">Title: <input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . attribute_escape( $title ) . '" /></label></p>' );
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance[ 'title' ] = $new_instance[ 'title' ];
        return $instance;
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
//        if ( get_option( 'pms_lypdos_show_recent_posts' ) == 'enabled' ) {
            echo $before_widget;
            $title = empty( $instance[ 'title' ] ) ? ' ' : apply_filters( 'widget_title', $instance[ 'title' ] );

            if ( !empty( $title ) )
                echo $before_title . $title . $after_title;;

            // WIDGET CODE GOES HERE
            $args = array(
            'numberposts' => 10,
            'category' => 0,
            'orderby' => 'modified',
            'order' => 'DESC',
//            'include' => '',
//            'exclude' => '',
            'post_type' => array( 'ctrl_doc', 'service', 'definition' ),
            'post_status' => 'publish',
            'suppress_filters' => true );
            
            echo '<ul class="sidebar-list">';

            $recent_posts = wp_get_recent_posts( $args );
            foreach ( $recent_posts as $recent ) {
                
                $label = get_post_type_object( $recent[ "post_type" ] )->labels->singular_name;
                $label_short = sprintf( '%3.3s', $label );
                echo '<li><a title="' . $label . '" href="' . get_permalink( $recent[ "ID" ] ) . '">' . ( __( $recent[ "post_title" ] )) . '</a> <span style="color:#7e7e7e">(' . $label_short . ')</span></li> ';
            }
            echo '</ul>';
  
            echo $after_widget;
//        }
    }

}

add_action( 'widgets_init', create_function( '', 'return register_widget("PamsRecentPostsWidget");' ) );
?>