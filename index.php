<?php

/*
  Plugin Name: Biee Inspired
  Description: An inspirational quote generator plugin 
  Plugin URI: https://github.com/petsamuel/wp-biee-inspired
  Version: 1.0
  License: MIT
  Author: Samuel Peters
  Author URI: https://github.com/petsamuel
*/

if (!defined('ABSPATH'))
  exit; // Exit if accessed directly

class Scaffold
{
  function __construct()
  {
    add_action('init', array($this, 'onInit'));
  }

  function onInit()
  {
    wp_register_script('bieeInspiredScript', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element', 'wp-editor'));
    wp_register_style('bieeInspiredStyle', plugin_dir_url(__FILE__) . 'build/index.css');

    register_block_type(
      'scaffold/custom-block',
      array(
        'render_callback' => array($this, 'renderCallback'),
        'editor_script' => 'bieeInspiredScript',
        'editor_style' => 'bieeInspiredStyle'
      )
    );
  }

  function renderCallback($attributes)
  {
    if (!is_admin()) {
      wp_enqueue_script('scaffoldScript', plugin_dir_url(__FILE__) . 'build/frontend.js', array('wp-element'));
      wp_enqueue_style('scaffoldStyles', plugin_dir_url(__FILE__) . 'build/index.css');
    }

    ob_start(); ?>
    <div class="boilerplate-update-me my-unique-plugin-wrapper-class">
      <pre style="display: none;"><?php echo wp_json_encode($attributes) ?></pre>
    </div>
    <?php return ob_get_clean();

  }

  function renderCallbackBasic($attributes)
  {
    return '<div class="boilerplate-frontend">Hello, the sky is ' . $attributes['skyColor'] . ' and the grass is ' . $attributes['grassColor'] . '.</div>';
  }
}

$scaffold = new Scaffold();