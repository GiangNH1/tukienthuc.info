<?php

namespace HLWP;

abstract class HL_Widget extends \WP_Widget {

	protected $fields = array();

	public function regField( $id, $label, $default = '', $type = 'text', $options = array() ) {
		$this->fields[] = array
		(
			'id'      => $id,
			'label'   => $label,
			'type'    => $type,
			'default' => $default,
			'options' => $options,
		);

		return $this;
	}

	public function form( $instance ) {
		echo $this->get_style_html_block();

		foreach ( $this->fields as $field ) {
			if ( in_array( $field['type'], array( 'select' ) ) ) {
				$this->add_form_field(
					! empty( $instance[ $field['id'] ] ) ? $instance[ $field['id'] ] : '',
					$field['id'],
					$field['label'],
					$field['type'],
					$field['default'],
					$field['options']
				);
			} else {
				$default = isset( $field['default'] ) ? $field['default'] : '';
				$this->add_form_field(
					! empty( $instance[ $field['id'] ] ) ? $instance[ $field['id'] ] : '',
					$field['id'],
					$field['label'],
					$field['type'],
					empty( $instance ) ? $default : '',
					$field['options']
				);
			}
		}
	}

	protected function get_style_html_block() {
		ob_start(); ?>
        <style>
            .ls-widget {
                margin: 10px 0;
            }

            .ls-widget label {
                margin-bottom: 5px;
                display: block;
                margin-left: 1px;
                font-weight: bold;
            }

            .ls-widget img {
                margin-top: 3px;
            }

            .ls-widget textarea {
                width: 100%;
                font-family: 'utm-avo', sans-serif;
            }
        </style>
		<?php
		return ob_get_clean();
	}

	protected function add_form_field(
		$field_value = '',
		$field_id,
		$field_label,
		$type = 'text',
		$default_value = '',
		$options = []
	) {
		if ( $type == 'text' ) :
			$field_value = ! empty( $field_value ) ? $field_value : ( ! empty( $default_value ) ? $default_value : '' );
			// $place_holder = $options['placeholder'];
			?>
            <div class="ls-widget">
                <label for="<?php echo $this->get_field_id( $field_id ); ?>"><?php _e( $field_label ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( $field_id ); ?>"
                       name="<?php echo $this->get_field_name( $field_id ); ?>" type="text"
                       value="<?php echo esc_attr( $field_value ); ?>">
            </div>
		<?php
        elseif ( $type == 'label' ) :
			?>
            <div class="ls-widget">
				<?php _e( $field_label ); ?>
            </div>
		<?php
        elseif ( $type == 'image' ) :
			$field_value = ! empty( $field_value ) ? $field_value : ( ! empty( $default_value ) ? $default_value : '' ); ?>
            <div class="ls-widget ls-widget-image">
                <label for="<?php echo $this->get_field_id( $field_id ); ?>"><?php _e( $field_label ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( $field_id ); ?>"
                       name="<?php echo $this->get_field_name( $field_id ); ?>" type="text"
                       value="<?php echo esc_attr( $field_value ); ?>">
                <img id="<?php echo $this->get_field_id( $field_id ); ?>_img"
                     class="<?php empty( $field_value ) ? 'hide' : '' ?>" src="<?php echo esc_attr( $field_value ); ?>"
                     alt="preview" height="100"/>
                <script type="text/javascript">
                    jQuery("#<?php echo $this->get_field_id( $field_id ); ?>").on('change', function () {
                        jQuery("#<?php echo $this->get_field_id( $field_id ); ?>_img").attr('src', jQuery(this).val());
                    });
                </script>
            </div>
		<?php
        elseif ( $type == 'imagepicker' ) :
			wp_enqueue_media();
			wp_enqueue_media();
			$field_value = ! empty( $field_value ) ? $field_value : ( ! empty( $default_value ) ? $default_value : '' ); ?>
            <div class="ls-widget ls-widget-image">
                <label for="<?php echo $this->get_field_id( $field_id ); ?>"><?php _e( $field_label ); ?></label>
                <input type='text' class="widefat" id="<?php echo $this->get_field_id( $field_id ); ?>"
                       name="<?php echo $this->get_field_name( $field_id ); ?>"
                       value='<?php echo esc_attr( $field_value ); ?>'>
                <div style="padding-top: 3px;">
                    <input id="<?php echo $this->get_field_id( $field_id ); ?>_upload_btn" type="button" class="button"
                           value="<?php _e( 'Add From Media' ); ?>"/>
                    <img id="<?php echo $this->get_field_id( $field_id ); ?>_img_prev"
                         class="<?php empty( $field_value ) ? 'hide' : '' ?>"
                         src="<?php echo esc_attr( $field_value ); ?>"
                         alt="preview" height="100"/>
                </div>
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        // Uploading files
                        var file_frame,
                            wp_media_post_id = wp.media.model.settings.post.id; // Store the old id

                        jQuery('#<?php echo $this->get_field_id( $field_id ); ?>_upload_btn').on('click', function (event) {
                            event.preventDefault();
                            // Create the media frame.
                            file_frame = wp.media.frames.file_frame = wp.media({
                                title: 'Select a image to upload',
                                button: {
                                    text: 'Use this image'
                                },
                                multiple: false	// Set to true to allow multiple files to be selected
                            });
                            // When an image is selected, run a callback.
                            file_frame.on('select', function () {
                                // We set multiple to false so only get one image from the uploader
                                var attachment = file_frame.state().get('selection').first().toJSON();
                                // Do something with attachment.id and/or attachment.url here
                                $('#<?php echo $this->get_field_id( $field_id ); ?>_img_prev').attr('src', attachment.url).css('width', 'auto');
                                $('#<?php echo $this->get_field_id( $field_id ); ?>').val(attachment.url);
								$("#<?php echo $this->get_field_id( $field_id ); ?>").trigger('change');
                                // Restore the main post ID
                                wp.media.model.settings.post.id = wp_media_post_id;
                            });
                            // Finally, open the modal
                            file_frame.open();
                        });

                        jQuery("#<?php echo $this->get_field_id( $field_id ); ?>").on('change', function () {
                            jQuery("#<?php echo $this->get_field_id( $field_id ); ?>_img_prev").attr('src', jQuery(this).val());
                        });
                    });
                </script>
            </div>
		<?php
        elseif ( $type == 'checkbox' ) :
			$field_value = ! empty( $field_value ) ? $field_value : ( ! empty( $default_value ) ? $default_value : '' );
			?>
            <div class="ls-widget">
                <input class="widefat" id="<?php echo $this->get_field_id( $field_id ); ?>"
                       name="<?php echo $this->get_field_name( $field_id ); ?>" type="checkbox"
                       value="<?php echo esc_attr( $field_value ); ?>" <?php echo ! empty( $field_value ) ? 'checked' : ''; ?>> <?php _e( $field_label ); ?>
                <script type="text/javascript">
                    jQuery("#<?php echo $this->get_field_id( $field_id ); ?>").on('click', function () {
                        jQuery(this).attr('value', this.checked ? 1 : 0);
                    });
                </script>
            </div>
		<?php
        elseif ( $type == 'textarea' ) :
			$field_value = ! empty( $field_value ) ? $field_value : ( ! empty( $default_value ) ? $default_value : '' ); ?>
            <div class="ls-widget ls-widget-image">
                <label for="<?php echo $this->get_field_id( $field_id ); ?>"><?php _e( $field_label ); ?></label>
                <textarea class="widefat" id="<?php echo $this->get_field_id( $field_id ); ?>"
                          name="<?php echo $this->get_field_name( $field_id ); ?>"
                          rows="8"><?php echo esc_attr( $field_value ); ?></textarea>
            </div>
		<?php
        elseif ( $type == 'select' ) :
			$field_value = ( empty( $field_value ) && 0 !== $field_value ) ? $default_value : $field_value; ?>
            <div class="ls-widget ls-widget-image">
                <label for="<?php echo $this->get_field_id( $field_id ); ?>"><?php _e( $field_label ); ?></label>
                <select class="widefat" id="<?php echo $this->get_field_id( $field_id ); ?>"
                        name="<?php echo $this->get_field_name( $field_id ); ?>">
					<?php foreach ( $options as $key => $option ): ?>
                        <option value="<?php echo $key; ?>" <?php if ( $field_value == $key ) {
							echo 'selected';
						} ?>><?php echo $option; ?></option>
					<?php endforeach; ?>
                </select>
            </div>
		<?php
        elseif ( $type == 'date' ) :
			$field_value = ( empty( $field_value ) && 0 !== $field_value ) ? $default_value : $field_value; ?>
            <div class="ls-widget ls-widget-image">
                <label for="<?php echo $this->get_field_id( $field_id ); ?>"><?php _e( $field_label ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( $field_id ); ?>"
                       name="<?php echo $this->get_field_name( $field_id ); ?>" type="text"
                       value="<?php echo esc_attr( $field_value ); ?>">
                <script type="text/javascript">

                </script>
            </div>
		<?php
        elseif ( $type == 'taxonomy' ) :
			$field_value = ( empty( $field_value ) && 0 !== $field_value ) ? $default_value : $field_value;
			$terms = get_terms( $options['taxonomy'], [ 'hide_empty' => false ] ); ?>
            <div class="ls-widget">
                <label for="<?php echo $this->get_field_id( $field_id ); ?>"><?php _e( $field_label ); ?></label>
                <select class="widefat"
                        id="<?php echo $this->get_field_id( $field_id ); ?>"
                        name="<?php echo $this->get_field_name( $field_id ); ?>"
					<?php echo ! empty( $options['multiple'] ) ? ' multiple size="4"' : ''; ?>>
                    <option>Please Select</option>
					<?php foreach ( $terms as $term ) :
						$value = empty( $options['useid'] ) ? $term->slug : $term->term_id;
						$selected = is_array( $field_value ) ? in_array( $value,
							$field_value ) : $field_value == $value;
						?>
                        <option value="<?php echo $value; ?>" <?php echo $selected ? 'selected' : ''; ?>>
							<?php echo $term->name; ?>
                        </option>
					<?php endforeach; ?>
                </select>
            </div>
		<?php
        elseif ( $type == 'post_type' ) :
			$field_value = ( empty( $field_value ) && 0 !== $field_value ) ? $default_value : $field_value;
			$posts = get_posts( [ 'post_type' => $options['post_type'], 'posts_per_page' => - 1 ] ); ?>
            <div class="ls-widget">
                <label for="<?php echo $this->get_field_id( $field_id ); ?>"><?php _e( $field_label ); ?></label>
                <select class="widefat" id="<?php echo $this->get_field_id( $field_id ); ?>"
                        name="<?php echo $this->get_field_name( $field_id ); ?>">
                    <option>Please select one</option>
					<?php foreach ( $posts as $post ) :
						?>
                        <option value="<?php echo $post->ID; ?>" <?php echo ( $field_value == $post->ID ) ? 'selected' : ''; ?>>
							<?php echo $post->post_title; ?>
                        </option>
					<?php endforeach; ?>
                </select>
            </div>
		<?php
		endif;
	}

	protected function is_expired( $exp_date ) {
		if ( ! empty( $exp_date ) ) {
			$expired_time = strtotime( $exp_date );

			if ( time() > $expired_time ) {
				// Hide this widget if the current time larger than the expired time
				return true;
			}
		}

		return false;
	}

	protected function val( $inst, $field_id, $pos = - 1 ) {
		echo $this->get_val( $inst, $field_id, $pos );
	}

	protected function get_val( $inst, $field_id, $pos = - 1 ) {
		if ( - 1 == $pos ) {
			$val = ! empty( $inst[ $field_id ] ) ? $inst[ $field_id ] : '';
		} else {
			$field_id = $field_id . '_' . $pos;
			$val      = ! empty( $inst[ $field_id ] ) ? $inst[ $field_id ] : '';
		}

		return $val;
	}

	protected function link_val( $inst, $field_id, $pos = - 1 ) {
		echo $this->get_link_val( $inst, $field_id, $pos );
	}

	protected function get_link_val( $inst, $field_id, $pos = - 1 ) {
		$val = trim( $this->get_val( $inst, $field_id, $pos ) );

		if ( '' !== $val && '#' !== $val && ! preg_match( '/#[a-zA-Z0-9_]*$/', $val ) ) {
			$val = trailingslashit( $val );
		}

		return $val;
	}

	protected function add_fields( $fields = array() ) {
		$this->fields = $fields;
	}

	protected function nl2p( $string, $line_breaks = true, $xml = true ) {
		$string = str_replace( array( '<p>', '</p>', '<br>', '<br />' ), '', $string );

		if ( $line_breaks == true ) {
			return '<p>' . preg_replace( array( "/([\n]{2,})/i", "/([^>])\n([^<])/i" ),
					array( "</p>\n<p>", '<br' . ( $xml == true ? ' /' : '' ) . '>' ),
					trim( $string ) ) . '</p>';
		} else {
			return '<p>' . preg_replace( "/([\n]{1,})/i", "</p>\n<p>", trim( $string ) ) . '</p>';
		}
	}
}

abstract class HL_Repeater_Widget extends HL_Widget {

	protected $repeater_fields = array();

	function __construct(
		$id_base,
		$name,
		$widget_options = array(),
		$control_options = array(),
		$total_repeat_fields = 1
	) {
		parent::__construct( $id_base, $name, $widget_options, $control_options );

		$this->regField(
			'repeater_total',
			'Number of groups of data',
			$total_repeat_fields
		);
	}

	public function regRepField( $id, $label, $default = '', $type = 'text' ) {
		$this->repeater_fields[] = array
		(
			'id'      => $id,
			'label'   => $label,
			'type'    => $type,
			'default' => $default,
		);

		return $this;
	}

	public function form( $inst ) {

		parent::form( $inst );

		$total = $this->get_total_groups( $inst );
		for ( $i = 0; $i < $total; $i ++ ) {
			echo "<h3>Group #" . ( $i + 1 ) . "</h3>";
			foreach ( $this->repeater_fields as $field ) {
				$field_id = $field['id'] . '_' . $i;
				$default  = isset( $field['default'] ) ? $field['default'] : '';
				$this->add_form_field(
					! empty( $inst[ $field_id ] ) ? $inst[ $field_id ] : '',
					$field_id,
					$field['label'],
					$field['type'],
					$default
				);
			}
		}
	}

	protected function get_total_groups( $inst ) {
		foreach ( $this->fields as $field ) {
			if ( 'repeater_total' == $field['id'] && isset( $inst[ $field['id'] ] ) ) {
				$total = $inst[ $field['id'] ];
				if ( ! empty( $total ) ) {
					return $total;
				} else {
					return $field['default'];
				}
			}
		}

		return false;
	}
}
