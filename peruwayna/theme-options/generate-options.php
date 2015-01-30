<?php
include 'includes/theme_info.php';

define('MENU_TITLE', 'Theme Options'); //Define your menu title
define('MENU_SLUG', 'theme_options'); //Define your menu slug, if you don't know what it is, just leave it as it is

if (!class_exists('reedwan_theme_options')) {

    class reedwan_theme_options {

        private $options;

        public function reedwan_theme_options($options) {
            $this->options = $options;

            add_action('admin_menu', array(&$this, 'reedwan_add_menu')); // Action that triggers function below
        }

        public function reedwan_add_menu() {
            add_menu_page(__(MENU_TITLE), __(MENU_TITLE), 'administrator', 'reedwan_options' . MENU_SLUG, array(&$this, 'reedwan_display_page'), get_template_directory_uri()."/theme-options/" . 'images/icon.png');
        }

        /* Function That Generates Main Content */

        public function reedwan_display_page() {
            ?>
            <?php $this->save_options(); ?>
            <form id="reedwan-settings" method="post">
                <input type="hidden" name="action" id="action" value="reedwan_save_options" />
                <div id="reedwan-sidebar">
                    <div id="reedwan-meta-info">
                        <h1><?php echo FRAMEWORK_NAME; ?></h1>
                        <h2>Theme: <?php echo THEME_NAME; ?></h2>
                        <h2>Author: <?php echo THEME_AUTHOR; ?></h2>
                        <h2>Version: <?php echo THEME_VERSION; ?></h2>
                    </div>
                    <ul id="reedwan-main-menu">

                        <?php $first = true; ?> 
                        <?php
                        /* Cycle that goes though $options array, it is searching for headings and sections to make navigation */

                        foreach ($this->options as $option):
                            if ($option['type'] == "section") :
                                $section = $option['id'];
                                ?>
                                <li><p><span class="<?php echo $option['icon']; ?>"></span><?php echo $option['title']; ?></p>
                                    <ul<?php if ($option['expanded'] == "true") echo ' class="default-accordion"'; ?>>
                                        <?php
                                        foreach ($this->options as $sections):
                                            if (($sections['section'] == $section) && (($sections['type'] == "heading") || ($sections['type'] == "html"))):
                                                ?>
                                                <li><a<?php
                            if ($first) {
                                echo ' class="defaulttab"';
                                $first = false;
                            }
                                                ?> href="#" rel="<?php echo $sections['id']; ?>"><p><?php echo $sections['title']; ?></p></a></li>
                                                    <?php
                                                endif;
                                            endforeach;
                                            ?> 
                                    </ul>
                                </li>
                                <?php
                            endif;
                        endforeach;
                        ?>
                    </ul>
                </div>


                <?php /* Below - script that generates divs for each tab */ ?>

                <div id="reedwan-content">
                    <?php foreach ($this->options as $option): ?> 
                        <?php if ($option['type'] == "heading"): ?>
                            <?php $under_section = $option['id']; ?>
                            <div class="tab-content" id="<?php echo $option['id']; ?>">
                                <div class="reedwan-settings-headline">
                                    <h2><?php echo $option['title']; ?></h2>
                                    <input name="save" class="save-button" type="submit" value="Save changes" />
                                </div>
                                <?php
                                /* Cycle that goes though options, and calls function for displaying input types */

                                foreach ($this->options as $item) {
                                    if ($item['under_section'] == $under_section) {
                                        switch ($item['type']) {
                                            case "text":
                                                $this->display_text($item);
                                                break;

                                            case "color":
                                                $this->display_color($item);
                                                break;

                                            case "small_heading":
                                                $this->display_small_heading($item);
                                                break;

                                            case "textarea":
                                                $this->display_textarea($item);
                                                break;

                                            case "image":
                                                $this->display_image($item);
                                                break;

                                            case "checkbox":
                                                $this->display_checkbox($item);
                                                break;

                                            case "checkbox_image":
                                                $this->display_checkbox_image($item);
                                                break;

                                            case "radio":
                                                $this->display_radio($item);
                                                break;

                                            case "toggle_div_start":
                                                $this->display_toggle_div_start($item);
                                                break;

                                            case "toggle_div_end":
                                                $this->display_toggle_div_end();
                                                break;

                                            case "radio_image":
                                                $this->display_radio_image($item);
                                                break;

                                            case "select":
                                                $this->display_select($item);
                                                break;
                                        }
                                    }
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($option['type'] == "html"): ?>
                            <div class="tab-content" id="<?php echo $option['id']; ?>">
                                <?php echo $option['source']; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div> 
            </form>

            <?php
        }

        /*         * *************************************
         * *************************************
         * ****                           ****** 
         * ****     Display functions     ******  
         * ****                           ******
         * *************************************
         * ************************************ */






        /* Normal text input ("type" => "text" */

        public function display_text($value) {
            $rel = "";
            if ($value['display_checkbox_id'])
                $rel = " rel=".$value['display_checkbox_id'];
            else
                $rel = "";
            ?>
            <div<?php echo $rel; ?> class="separator">
                <div class="label">
                    <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                </div>
                <div class="settings-content">
                    <div class="reedwan_image_preview">
                        <?php if ($value['img_desc']): ?>
                            <img src="<?php echo $value['img_desc']; ?>" />
                        <?php endif; ?>
                    </div>
                    <input<?php if ($value['placeholder']) echo ' placeholder="' . $value['placeholder'] . '"'; ?> class="reedwan-fullwidth" id="<?php echo $value['id']; ?>" name="<?php echo $value['id']; ?>" type="text" value="<?php if (get_option($value['id'])) echo esc_html(stripslashes(get_option($value['id'])));else echo $value['default']; ?>" />
                    <p class="description"><?php echo $value['desc']; ?></p>
                </div>
            </div>
            <?php
        }
        
        
        /* Color picker ("type" => "color") */

        public function display_color($value) {
            $rel = "";
            if ($value['display_checkbox_id'])
                $rel = " rel=".$value['display_checkbox_id'];
            else
                $rel = "";
            ?>
            <?php
            if (get_option($value['id']))
                $color = ' style="background-color: #' . get_option($value['id']) . ';"';
            else if ($value['default'])
                $color = ' style="background-color: #' . $value['default'] . ';"'
                ?>

            <div<?php echo $rel; ?> class="separator">
                <div class="label">
                    <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                </div>
                <div class="settings-content">
                    <div class="reedwan_image_preview">
                        <?php if ($value['img_desc']): ?>
                            <img src="<?php echo $value['img_desc']; ?>" />
                        <?php endif; ?>
                    </div>
                    <input<?php if ($value['placeholder']) echo ' placeholder="' . $value['placeholder'] . '"'; ?> class="reedwan-color-picker"<?php echo $color; ?> id="<?php echo $value['id']; ?>" name="<?php echo $value['id']; ?>" type="text" value="<?php if (get_option($value['id'])) echo esc_html(stripslashes(get_option($value['id'])));else echo $value['default']; ?>" />
					<p class="description"><?php echo $value['desc']; ?></p>
                </div>
            </div>
            <?php
        }

        /* Image Upload ("type" => "image") */

        public function display_image($value) {
            $rel = "";
            if ($value['display_checkbox_id'])
                $rel = " rel=".$value['display_checkbox_id'];
            else
                $rel = "";
            ?>
            <div<?php echo $rel; ?> class="separator">
                <div class="label">
                    <label><?php echo $value['name']; ?></label>
                </div>
                <div class="settings-content">
                    <?php
                    if (get_option($value['id']))
                        $def_value = stripslashes(get_option($value['id']));
                    else
                        $def_value = $value['default'];
                    ?>
                    <input<?php if ($value['placeholder']) echo ' placeholder="' . $value['placeholder'] . '"'; ?> class="reedwan-fullwidth" type="text" value="<?php echo $def_value; ?>" name="<?php echo $value['id']; ?>" />


                    <span class="upload reedwan_upload reedwan-button-blue" id="<?php echo $value['id']; ?>">Upload image</span>
                    <?php if (get_option($value['id'])): ?>
                        <span type="button" class="reedwan_remove reedwan-button" id="remove_<?php echo $value['id']; ?>">Remove image</span>
                    <?php endif; ?>

                    <div class="reedwan_image_preview">
                        <?php if (get_option($value['id'])): ?>
                            <img src="<?php echo get_option($value['id']); ?>" />
                        <?php elseif ($value['default'] != ""): ?>
                            <img src="<?php echo $value['default']; ?>" />
                        <?php endif; ?>
                    </div>

                    <p class="description"><?php echo $value['desc']; ?></p>

                </div>
            </div>
            <?php
        }

        /* Textarea input ("type" => "textarea") */

        public function display_textarea($value) {
            $rel = "";
            if ($value['display_checkbox_id'])
                $rel = " rel=".$value['display_checkbox_id'];
            else
                $rel = "";
            ?>
            <div<?php echo $rel; ?> class="separator">
                <div class="label">
                    <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                </div>
                <div class="settings-content">
                    <div class="reedwan_image_preview">
                        <?php if ($value['img_desc']): ?>
                            <img src="<?php echo $value['img_desc']; ?>" />
                        <?php endif; ?>
                    </div>
                    <textarea<?php if ($value['placeholder']) echo ' placeholder="' . $value['placeholder'] . '"'; ?> id="<?php echo $value['id']; ?>" name="<?php echo $value['id']; ?>" cols="70" rows="8"><?php
            if (get_option($value['id']))
                echo stripslashes(get_option($value['id']));
            else
                echo $value['default'];
                        ?></textarea>
                    <p class="description"><?php echo $value['desc']; ?></p>
                </div>
            </div>
            <?php
        }

        /* Select input ("type" => "select") */

        public function display_select($value) {
            $rel = "";
            if ($value['display_checkbox_id'])
                $rel = " rel=".$value['display_checkbox_id'];
            else
                $rel = "";
            ?>
            <div<?php echo $rel; ?> class="separator">
                <div class="label">
                    <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                </div>
                <div class="settings-content">
                    <div class="reedwan_image_preview">
                        <?php if ($value['img_desc']): ?>
                            <img src="<?php echo $value['img_desc']; ?>" />
                        <?php endif; ?>
                    </div>
                    <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                        <?php
                        if (get_option($value['id']))
                            $default = get_option($value['id']);
                        else
                            $default = $value['default'];



                        foreach ($value['options'] as $option):
                            $selected = '';
                            if ($option == $default)
                                $selected = ' selected="selected"';
                            ?>
                            <option <?php echo $selected; ?>><?php echo $option ?></option>
                        <?php endforeach; ?>


                    </select>
                    <p class="description"><?php echo $value['desc']; ?></p>
                </div>
            </div>
            <?php
        }

        /* Normal checkbox ("type" => "checkbox") */

        public function display_checkbox($value) {
            $rel = "";
            if ($value['display_checkbox_id'])
                $rel = " rel=".$value['display_checkbox_id'];
            else
                $rel = "";
            ?>
            <div<?php echo $rel; ?> class="separator">
                <div class="label">
                    <label><?php echo $value['name']; ?></label>
                </div>
                <div class="settings-content">
                    <div class="reedwan_image_preview">
                        <?php if ($value['img_desc']): ?>
                            <img src="<?php echo $value['img_desc']; ?>" />
                        <?php endif; ?>
                    </div>
                    <?php
                    $i = 0;
                    foreach ($value['options'] as $box):
                        $checked = '';

                        if (get_option($value['id'][$i])) {
                            if (get_option($value['id'][$i]) == 'true')
                                $checked = ' checked="checked"';

                            else
                                $checked = '';
                        }

                        else {
                            if ($value['default'][$i] == "checked")
                                $checked = ' checked="checked"';
                        }
                        ?>
                        <label for="<?php echo $value['id'][$i]; ?>">
                            <input type="checkbox"<?php echo $checked; ?> name="<?php echo $value['id'][$i]; ?>" id="<?php echo $value['id'][$i]; ?>" />
                            <?php echo $box; ?>
                        </label>
                        <?php
                        $i++;
                    endforeach;
                    ?>
                    <p class="description"><?php echo $value['desc']; ?></p>
                </div>
            </div>
            <?php
        }

        /* Image checkbox ("type" => "checkbox_image") */

        public function display_checkbox_image($value) {
            $rel = "";
            if ($value['display_checkbox_id'])
                $rel = " rel=".$value['display_checkbox_id'];
            else
                $rel = "";
            ?>
            <div<?php echo $rel; ?> class="separator">
                <div class="label">
                    <label><?php echo $value['name']; ?></label>
                </div>
                <div class="settings-content">
                    <div class="cOf">
                        <?php
                        $i = 0;
                        foreach ($value['options'] as $box):
                            $checked = '';
                            $class = '';
                            $img_size = '';

                            if ($value['image_size'][$i])
                                $img_size = 'width="' . $value['image_size'][$i] . '"';
                            else if ($value['image_size'][$i] == false && $value['image_size'][0] == true)
                                $img_size = 'width="' . $value['image_size'][0] . '"';
                            else
                                $img_size = 'width="120"';




                            if (get_option($value['id'][$i])) {
                                if (get_option($value['id'][$i]) == 'true') {
                                    $checked = ' checked="checked"';
                                    $class = ' reedwan-img-selected';
                                }
                            } elseif ($value['default'][$i] == "checked") {
                                $class = ' reedwan-img-selected';
                                $checked = ' checked="checked"';
                            }
                            ?>
                            <label class="reedwan-image-checkbox<?php echo $class; ?>" for="<?php echo $value['id'][$i]; ?>">
                                <img <?php echo $img_size; ?> src="<?php echo $value['image_src'][$i]; ?>" alt="<?php echo $box ?>" />
                                <input class="reedwan-image-checkbox-b" type="checkbox"<?php echo $checked; ?> name="<?php echo $value['id'][$i]; ?>" id="<?php echo $value['id'][$i]; ?>" />
                                <?php if ($value['show_labels'] == "true"): ?><p><?php echo $box; ?></p><?php endif; ?>
                            </label>
                            <?php
                            $i++;
                        endforeach;
                        ?>
                    </div>
                    <p class="description"><?php echo $value['desc']; ?></p>
                </div>
            </div>
            <?php
        }

        /* Normal radio input ("type" => "radio") */

        public function display_radio($value) {
            $rel = "";
            if ($value['display_checkbox_id'])
                $rel = " rel=".$value['display_checkbox_id'];
            else
                $rel = "";
            ?>
            <div<?php echo $rel; ?> class="separator">
                <div class="label">
                    <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                </div>
                <div class="settings-content">
                    <div class="reedwan_image_preview">
                        <?php if ($value['img_desc']): ?>
                            <img src="<?php echo $value['img_desc']; ?>" />
                        <?php endif; ?>
                    </div>
                    <?php
                    $i = 0;

                    if (get_option($value['id']))
                        $default = get_option($value['id']);
                    else
                        $default = $value['default'];

                    foreach ($value['options'] as $option):
                        $checked = '';

                        if ($value['options'][$i] == $default) {
                            $checked = ' checked="checked"';
                        }
                        ?>
                        <label for="<?php echo $value['id'] . $i; ?>">
                            <input type="radio" id="<?php echo $value['id'] . $i; ?>" name="<?php echo $value['id']; ?>" value="<?php echo $value['options'][$i]; ?>" <?php echo $checked; ?> />
                            <?php echo $option; ?>
                        </label>
                        <?php
                        $i++;
                    endforeach;
                    ?>
                    <p class="description"><?php echo $value['desc']; ?></p>
                </div>
            </div>
            <?php
        }

        /* Image radio input ("type" => "radio_image") */

        public function display_radio_image($value) {
            $rel = "";
            if ($value['display_checkbox_id'])
                $rel = " rel=".$value['display_checkbox_id'];
            else
                $rel = "";
            ?>
            <div<?php echo $rel; ?> class="separator">
                <div class="label">
                    <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                </div>
                <div class="settings-content">
                    <div class="cOf">
                        <?php
                        $i = 0;

                        if (get_option($value['id']))
                            $default = get_option($value['id']);
                        else
                            $default = $value['default'];

                        foreach ($value['options'] as $option):
                            $class = '';
                            $img_size = '';
                            $checked = '';

                            if ($value['image_size'][$i])
                                $img_size = 'width="' . $value['image_size'][$i] . '"';
                            else if ($value['image_size'][$i] == false && $value['image_size'][0] == true)
                                $img_size = 'width="' . $value['image_size'][0] . '"';
                            else
                                $img_size = 'width="120"';

                            if ($value['options'][$i] == $default) {
                                $checked = ' checked="checked"';
                                $class = ' reedwan-img-selected';
                            }
                            ?>
                            <label class="reedwan-image-radio<?php echo $class; ?>" for="<?php echo $value['id'] . $i; ?>">
                                <img <?php echo $img_size; ?> src="<?php echo $value['image_src'][$i]; ?>" alt="<?php echo $box ?>" />
                                <input class="reedwan-image-radio-b" type="radio" id="<?php echo $value['id'] . $i; ?>" name="<?php echo $value['id']; ?>" value="<?php echo $value['options'][$i]; ?>" <?php echo $checked; ?> />
                                <?php if ($value['show_labels'] == "true"): ?><p><?php echo $option; ?></p><?php endif; ?>
                            </label>
                            <?php
                            $i++;
                        endforeach;
                        ?>
                    </div>
                    <p class="description"><?php echo $value['desc']; ?></p>
                </div>
            </div>
            <?php
        }

        /* Displays small Heading in tabs */

        public function display_small_heading($value) {
            $rel = "";
            if ($value['display_checkbox_id'])
                $rel = " rel=".$value['display_checkbox_id'];
            else
                $rel = "";
            ?>
            <div<?php echo $rel; ?> class="separator">
                <h4><?php echo $value['title']; ?></h4>
            </div>
            <?php
        }
        
        /* Hiding div start ("type" => "toggle_div_start" */
        
        public function display_toggle_div_start($value) {
            $rel = "";
            if ($value['display_checkbox_id'])
                $rel = " rel=".$value['display_checkbox_id'];
            else
                $rel = "";
            ?>
                <div<?php echo $rel; ?>>
            <?php
        }
        
        
        /* Hiding div end ("type" => "toggle_div_end" */
        
        public function display_toggle_div_end() {
            ?>
                </div>                    
            <?php
        }


        /*         * *************************************
         * *************************************
         * ****                           ****** 
         * ****      Saving function      ******  
         * ****                           ******
         * *************************************
         * ************************************ */

        public function save_options() {

            if (isset($_POST['action']) && $_POST['action'] == "reedwan_save_options") {
                foreach ($this->options as $value) {
                    $the_type = $value['type'];

                    if ($the_type == "heading" || $the_type == "section" || $the_type == "small_heading")
                        continue;

                    else if ($the_type != "checkbox" && $the_type != "checkbox_image") {
                        update_option($value['id'], $_POST[$value['id']]);
                    } else if ($the_type == "checkbox" || $the_type == "checkbox_image") {
                        $i = 0;

                        foreach ($value['options'] as $box) {
                            $curr_id = $value['id'][$i];

                            if (isset($_POST[$curr_id]))
                                update_option($curr_id, 'true');

                            else
                                update_option($curr_id, 'false');
                            $i++;
                        }
                    }
                }
            }
        }

    }

}
?>
