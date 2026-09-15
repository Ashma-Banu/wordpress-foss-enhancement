<?php
/**
 * Twenty Twenty-Five functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

if ( ! function_exists( 'twentytwentyfive_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_post_format_setup' );

if ( ! function_exists( 'twentytwentyfive_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_editor_style() {
		add_editor_style( 'assets/css/editor-style.css' );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_editor_style' );

if ( ! function_exists( 'twentytwentyfive_enqueue_styles' ) ) :
	/**
	 * Enqueues the theme stylesheet on the front.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_enqueue_styles() {
		$suffix = SCRIPT_DEBUG ? '' : '.min';
		$src    = 'style' . $suffix . '.css';

		wp_enqueue_style(
			'twentytwentyfive-style',
			get_parent_theme_file_uri( $src ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
		wp_style_add_data(
			'twentytwentyfive-style',
			'path',
			get_parent_theme_file_path( $src )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'twentytwentyfive_enqueue_styles' );

if ( ! function_exists( 'twentytwentyfive_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfive' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_block_styles' );

if ( ! function_exists( 'twentytwentyfive_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfive_page',
			array(
				'label'       => __( 'Pages', 'twentytwentyfive' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfive' ),
			)
		);

		register_block_pattern_category(
			'twentytwentyfive_post-format',
			array(
				'label'       => __( 'Post formats', 'twentytwentyfive' ),
				'description' => __( 'A collection of post format patterns.', 'twentytwentyfive' ),
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_pattern_categories' );

if ( ! function_exists( 'twentytwentyfive_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_register_block_bindings() {
		register_block_bindings_source(
			'twentytwentyfive/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'twentytwentyfive' ),
				'get_value_callback' => 'twentytwentyfive_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_register_block_bindings' );

if ( ! function_exists( 'twentytwentyfive_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function twentytwentyfive_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;
/* Custom Dark/Light Mode Feature */

function medtwin_dark_mode_assets() {
    ?>
    <style>
        body.dark-mode {
            background-color: #121212 !important;
            color: #ffffff !important;
        }

        body.dark-mode a {
            color: #90caf9 !important;
        }

        #dark-mode-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            padding: 10px 16px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            background: #222;
            color: #fff;
            font-size: 14px;
        }
    </style>

    <button id="dark-mode-toggle">🌙 Dark Mode</button>

    <script>
        document.getElementById('dark-mode-toggle').onclick = function() {
            document.body.classList.toggle('dark-mode');

            if (document.body.classList.contains('dark-mode')) {
                this.innerHTML = '☀️ Light Mode';
            } else {
                this.innerHTML = '🌙 Dark Mode';
            }
        };
    </script>
    <?php
}

add_action('wp_footer', 'medtwin_dark_mode_assets');
/* Custom Like Button Feature */

function medtwin_like_button() {
    ?>
    <button class="medtwin-like-button" onclick="this.classList.toggle('liked')">
        ❤️ Like <span>12</span>
    </button>

    <style>
        .medtwin-like-button {
            padding: 10px 18px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            background: #f0f0f0;
            font-size: 15px;
        }

        .medtwin-like-button.liked {
            background: #ffdddd;
        }
    </style>
    <?php
}

add_action('wp_footer', 'medtwin_like_button');
/* Custom Author Information Card */

function medtwin_author_card() {
    ?>
    <div class="medtwin-author-card">
        <h3>👤 About the Author</h3>
	<p>Ashma Banu M<p>
        <p><strong>WordPress Developer</strong></p>
        <p>Creating useful and engaging content using open-source technologies.</p>
    </div>

    <style>
        .medtwin-author-card {
    margin: 25px auto;
    padding: 20px;
    max-width: 500px;
    background: #f5f5f5;
    color: #222;
    border-radius: 12px;
    text-align: center;
    border: 1px solid #ddd;
}

body.dark-mode .medtwin-author-card {
    background: #222 !important;
    color: #fff !important;
    border-color: #555;
}

        .medtwin-author-card h3 {
            margin-bottom: 10px;
        }
    </style>
    <?php
}

add_action('wp_footer', 'medtwin_author_card');
/* Custom Enhanced Search Box */

function medtwin_enhanced_search() {
    ?>
    <div class="medtwin-search-box">
        <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="text"
                   name="s"
                   placeholder="🔍 Search articles..."
                   value="<?php echo get_search_query(); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <style>
        .medtwin-search-box {
            text-align: center;
            margin: 25px auto;
        }

        .medtwin-search-box input {
            width: 280px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 20px;
            font-size: 15px;
        }

        .medtwin-search-box button {
            padding: 12px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            background: #222;
            color: white;
        }

        body.dark-mode .medtwin-search-box input {
            background: #222;
            color: white;
            border-color: #555;
        }

        body.dark-mode .medtwin-search-box button {
            background: #90caf9;
            color: #111;
        }
    </style>
    <?php
}

add_action('wp_footer', 'medtwin_enhanced_search');
