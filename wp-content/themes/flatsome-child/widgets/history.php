<?php

namespace HLApp\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class HLWP_History_Widget extends \HLWP\HL_Repeater_Widget {
	public function __construct() {
		parent::__construct( 'hlwp_History_widget',
			'Lịch sử hình thành & Phát triển',
			[
				'description'   => 'Lịch sử hình thành & Phát triển',
				'panels_icon'   => 'dashicons dashicons-slides icon-color',
				'panels_groups' => [ 'hlwp' ],
			],
			[],
			0 );


        $this->regField( 'hl_title', 'Tiêu đề ', '', 'text', ['placeholder'   => ''])
             ->regRepField( 'slide_year_1', 'Từ Năm', '')
             ->regRepField( 'slide_year_2', 'Đến Năm', '')
             ->regRepField( 'slide_image_title_1', 'Tiêu đề', '')
             ->regRepField( 'slide_image_title_2', 'Miêu tả', '','textarea');
	}

	public function widget( $args, $inst ) {
		$total       = $this->get_total_groups( $inst );
        $title = $this->get_val( $inst, 'hl_title' );
		?>
        <div class="history-company">
            <div class="hl-container-fluid">
                <div class="main-timeline" >
                    <?php for ( $i = 0; $i < $total; $i ++ ): ?>
                        <div class="timeline">
                            <div class="timeline-icon">
                                <span class="year"><span class="year-child"><?php $this->val( $inst, 'slide_year_1', $i ) ?>
                                <?php $this->val( $inst, 'slide_year_2', $i ) ?></span>
                                </span>
                            </div>
                            <div class="timeline-content">
                                <h3 class="title"><?php $this->val( $inst, 'slide_image_title_1', $i ) ?></h3>
                                <div class="description">
                                    <?php $this->val( $inst, 'slide_image_title_2', $i ) ?>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
		<?php
	}
}

add_action( 'widgets_init',
	function () {
		register_widget( __NAMESPACE__ . '\\HLWP_History_Widget' );
	}
);