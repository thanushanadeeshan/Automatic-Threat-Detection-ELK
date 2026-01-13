<div class="theme-offer">
   <?php
        // Check if the demo import has been completed
        $it_security_demo_import_completed = get_option('it_security_demo_import_completed', false);

        // If the demo import is completed, display the "View Site" button
        if ($it_security_demo_import_completed) {
            echo '<br>';
            echo '<div class="success">Demo Import Successful</div>';
            echo '<br>';
            echo '<hr>';
            echo '<br>';
            echo '<span>' . esc_html__( 'You can now visit your site or customize it further.', 'it-security' ) . '</span>';
            echo '<br>';
            echo '<br>';
            echo '<br>';
            echo '<div class="view-site-btn">';
            echo '<a href="' . esc_url(home_url()) . '" class="button button-primary button-large" style="margin-top: 10px;" target="_blank">View Site</a>';
            echo '<a href="' . esc_url( admin_url('customize.php') ) . '" class="button button-primary button-large" style="margin-top: 10px;" target="_blank">Customize Demo Content</a>';
            echo '</div>';
        }
     // POST and update the customizer and other related data of IT Security
    if ( isset( $_POST['submit'] ) ) {
        echo '<div class="plugin-notice">';
            // Check if Classic Blog Grid plugin is installed
            if (!is_plugin_active('classic-blog-grid/classic-blog-grid.php')) {
                // Plugin slug and file path for Classic Blog Grid
                $it_security_plugin_slug = 'classic-blog-grid';
                $it_security_plugin_file = 'classic-blog-grid/classic-blog-grid.php';
            
                // Check if Classic Blog Grid is installed and activated
                if ( ! is_plugin_active( $it_security_plugin_file ) ) {
            
                    // Check if Classic Blog Grid is installed
                    $it_security_installed_plugins = get_plugins();
                    if ( ! isset( $it_security_installed_plugins[ $it_security_plugin_file ] ) ) {
            
                        // Include necessary files to install plugins
                        include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
                        include_once( ABSPATH . 'wp-admin/includes/file.php' );
                        include_once( ABSPATH . 'wp-admin/includes/misc.php' );
                        include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
            
                        // Download and install Classic Blog Grid
                        $it_security_upgrader = new Plugin_Upgrader();
                        $it_security_upgrader->install( 'https://downloads.wordpress.org/plugin/classic-blog-grid.latest-stable.zip' );
                    }
            
                    // Activate the Classic Blog Grid plugin after installation (if needed)
                    activate_plugin( $it_security_plugin_file );
                }
            }
        echo '</div>';

        // ------- Create Main Menu --------
        $it_security_menuname = 'Primary Menu';
        $it_security_bpmenulocation = 'primary';
        $it_security_menu_exists = wp_get_nav_menu_object( $it_security_menuname );
    
        if (!$it_security_menu_exists) {
            // Create a new menu
            $it_security_menu_id = wp_create_nav_menu($it_security_menuname);

            // Define pages to be created
            $it_security_pages = array(
                'home' => array(
                    'title' => 'Home',
                    'template' => '/templates/template-home-page.php'
                ),
                'about' => array(
                    'title' => 'About',
                    'content' => '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>'
                ),
                'services' => array(
                    'title' => 'Services',
                    'content' => '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>'
                ),
                'pages' => array(
                    'title' => 'Pages',
                    'content' => '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>'
                ),
                'blogs' => array(
                    'title' => 'Blogs',
                    'content' => ''
                ),
            );

            $it_security_page_ids = array();

            // Loop through the pages and create them if they don’t exist
            foreach ($it_security_pages as $it_security_slug => $it_security_data) {
                $it_security_existing_page = get_page_by_path($it_security_slug);

                if ($it_security_existing_page) {
                    // If the page already exists, use its ID
                    $it_security_page_id = $it_security_existing_page->ID;
                } else {
                    // Create a new page
                    $it_security_page_data = array(
                        'post_type'    => 'page',
                        'post_title'   => $it_security_data['title'],
                        'post_content' => isset($it_security_data['content']) ? $it_security_data['content'] : '',
                        'post_status'  => 'publish',
                        'post_author'  => get_current_user_id(), // Set author dynamically
                        'post_name'    => $it_security_slug,
                    );

                    $it_security_page_id = wp_insert_post($it_security_page_data);

                    // Assign custom page template if specified
                    if (!empty($it_security_data['template'])) {
                        update_post_meta($it_security_page_id, '_wp_page_template', $it_security_data['template']);
                    }
                }

                // Store the page IDs
                $it_security_page_ids[$it_security_slug] = $it_security_page_id;
            }

            // Set homepage and blog page
            update_option('page_for_posts', $it_security_page_ids['blogs']);
            update_option('page_on_front', $it_security_page_ids['home']);
            update_option('show_on_front', 'page');

            // Define menu items
            $it_security_menu_items = array(
                'home',
                'about',
                'services',
                'pages',
                'blogs',
            );

            // Add menu items dynamically
            foreach ($it_security_menu_items as $it_security_slug) {
                wp_update_nav_menu_item($it_security_menu_id, 0, array(
                    'menu-item-title' => esc_html($it_security_pages[$it_security_slug]['title']),
                    'menu-item-url' => get_permalink($it_security_page_ids[$it_security_slug]),
                    'menu-item-status' => 'publish',
                    'menu-item-object-id' => $it_security_page_ids[$it_security_slug],
                    'menu-item-object' => 'page',
                    'menu-item-type' => 'post_type',
                ));
            }

            // Assign menu to theme location
            $it_security_locations = get_theme_mod('nav_menu_locations', array());
            $it_security_locations[$it_security_bpmenulocation] = $it_security_menu_id;
            set_theme_mod('nav_menu_locations', $it_security_locations);
        }

        //Logo
        set_theme_mod( 'it_security_the_custom_logo', esc_url( get_template_directory_uri().'/images/Logo.png'));

        //Header Section
        set_theme_mod( 'it_security_topbar_text', 'Stay Secure! Get a Free Cybersecurity Audit – Limited Time Offer!');
        set_theme_mod( 'it_security_header_user_link', '#');

        //Slider Section
        set_theme_mod( 'it_security_banner', true);

        // Function to fetch or create a page using WP_Query
        function get_or_create_page_by_title( $it_security_page_title, $it_security_page_content = '' ) {
            $it_security_args = array(
                'post_type'      => 'page',
                'title'          => $it_security_page_title,
                'post_status'    => 'publish',
                'posts_per_page' => 1,
                'fields'         => 'ids'
            );
            $it_security_query = new WP_Query( $it_security_args );

            if ( ! empty( $it_security_query->posts ) ) {
                return $it_security_query->posts[0];
            } else {
                // Create the page if it doesn't exist
                $it_security_page_id = wp_insert_post( array(
                    'post_type'    => 'page',
                    'post_title'   => $it_security_page_title,
                    'post_content' => $it_security_page_content,
                    'post_status'  => 'publish',
                    'post_author'  => 1
                ));
                return $it_security_page_id;
            }
        }

        // Create Page
        $it_security_page_title = 'Cybersecurity Solutions: Protect, Prevent, and Stay Secure Online!';
        $it_security_page_content = 'Stay ahead of cyber threats with our advanced security solutions. We protect your data, detect vulnerabilities, and defend against attacks, ensuring a safe digital environment for businesses and individuals. Secure your future today!';
        $it_security_page_id = get_or_create_page_by_title( $it_security_page_title, $it_security_page_content );

        if ( $it_security_page_id ) {
            set_theme_mod( 'it_security_banner_pageboxes', $it_security_page_id );
        } else {
            error_log('Failed to create or fetch the "Welcome to Corporate Business Theme" page.');
        }

        $it_security_image_url = get_template_directory_uri().'/images/banner-img.svg';
        $it_security_image_id = media_sideload_image($it_security_image_url, $it_security_page_id, null, 'id');
        if (!is_wp_error($it_security_image_id)) {
            // Set the downloaded image as the post's featured image
            set_post_thumbnail($it_security_page_id, $it_security_image_id);
        }  

        //Manage Case Section
        set_theme_mod( 'it_security_show_case_section', true);
        set_theme_mod( 'it_security_case_study_sec_title', 'Case Studies');
        set_theme_mod( 'it_security_case_study_sec_text', 'We provide cutting-edge cybersecurity solutions to protect businesses from evolving digital threats.');

        $it_security_featured_trainer_category_id = wp_create_category('Security');
        set_theme_mod('it_security_select_case_cat', 'Security');
        
        $it_security_trainer_titles = array(
            'Strengthening E-Commerce Security.',
            'Enhancing Cloud Security.',
            'Preventing Data Breach for a Law Firm',
            'Preventing a Major Ransomware Attack.',
            'cybersecurity solutions'
        );                 
        $it_security_trainer_content = '<p>A law firm storing sensitive client data faced a potential data breach. We implemented advanced encryption, access restrictions, and secure backup solutions, ensuring confidentiality and preventing unauthorized access.</p>';
        
        for ($it_security_i = 0; $it_security_i < 5; $it_security_i++) {
            set_theme_mod('it_security_title' . ($it_security_i + 1), $it_security_trainer_titles[$it_security_i]);
        
            $it_security_trainer_my_post = array(
                'post_title'    => wp_strip_all_tags($it_security_trainer_titles[$it_security_i]),
                'post_content'  => $it_security_trainer_content,
                'post_status'   => 'publish',
                'post_type'     => 'post',
                'post_category' => array($it_security_featured_trainer_category_id),
            );
        
            $it_security_trainer_post_id = wp_insert_post($it_security_trainer_my_post);
        
            if (!is_wp_error($it_security_trainer_post_id)) {
                $it_security_image_url = get_template_directory_uri() . '/images/service' . ($it_security_i + 1) . '.png';
                $it_security_image_id = media_sideload_image($it_security_image_url, $it_security_trainer_post_id, null, 'id');
                if (!is_wp_error($it_security_image_id)) {
                    set_post_thumbnail($it_security_trainer_post_id, $it_security_image_id);
                } else {
                    error_log('Failed to set post thumbnail for post ID: ' . $it_security_trainer_post_id);
                }
            } else {
                error_log('Failed to create post: ' . print_r($it_security_trainer_post_id, true));
            }
        }
        
        // Show success message and the "View Site" button
        update_option('it_security_demo_import_completed', true);
        echo '<br>';
        echo '<div class="success">Demo Import Successful</div>';
        echo '<br>';
        echo '<hr>';
        echo '<br>';
        echo '<span>' . esc_html__( 'You can now visit your site or customize it further.', 'it-security' ) . '</span>';
        echo '<br>';
    }
     ?>
    <ul>
        <li>
        <?php 
        // Check if the form is submitted
        if ( !isset( $_POST['submit'] ) ) : ?>
            <!-- Show demo importer form only if it's not submitted -->
            <?php if (!get_option('it_security_demo_import_completed')) : ?>
                <span><?php echo esc_html( 'Click on the below content to get demo content installed.', 'it-security' ); ?></span>
                <br><br>
                <hr><br>
                <b class="note"><?php echo esc_html('Note :', 'it-security' ); ?></b><br><br>
                <small><b><?php echo esc_html('Please take a backup if your website is already live with data. This importer will overwrite existing data.', 'it-security' ); ?></b></small><br><br>
                <form id="demo-importer-form" action="" method="POST" onsubmit="return runDemoImport();">
                    <input type="submit" name="submit" value="<?php echo esc_attr('Run Importer','it-security'); ?>" class="button button-primary button-large">
                </form>
                <script type="text/javascript">
                    function runDemoImport() {
                        if (confirm('Do you really want to do this?')) {
                            document.getElementById('demo-import-loader').style.display = 'block';
                            return true;
                        }
                        return false;
                    }
                </script>
             <?php endif; ?>
         <?php 
        endif; 

        // Show "View Site" button after form submission
        if ( isset( $_POST['submit'] ) ) {
        echo '<div class="view-site-btn">';
        echo '<a href="' . esc_url(home_url()) . '" class="button button-primary button-large" style="margin-top: 10px;" target="_blank">View Site</a>';
        echo '<a href="' . esc_url( admin_url('customize.php') ) . '" class="button button-primary button-large" style="margin-top: 10px;" target="_blank">Customize Demo Content</a>';
        echo '</div>';
        }
        ?>
        </li>
    </ul>
 </div>