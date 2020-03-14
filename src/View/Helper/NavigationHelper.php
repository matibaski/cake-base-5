<?php 
namespace App\View\Helper;

use Cake\View\Helper;

class NavigationHelper extends Helper
{
	public $helpers = ['Html', 'Form'];

	public function navTree($array, $level, $encodeUrl = false) {
		echo '<ol class="dd-list" data-level="' . $level . '">' . "\n";

		if(empty($array)) {
			echo '<li class="dd-item dd3-item placeholder disabled"><div class="dd-handle dd3-handle"></div><div class="dd3-content">Placeholder</div></li>';
		} else {
			foreach($array as $el) {
				echo '<li class="dd-item dd3-item" data-id="' . $el['id'] . '" data-title="' . $el['title'] . '" data-icon="' . $el['icon'] . '" data-link=\'' . $el['link'] . '\'>' . "\n";
				echo '<div class="dd-handle dd3-handle"></div><div class="dd3-content">' . "\n";
				
				$editLink = $this->Html->link(
					'<i class="fas fa-fw fa-edit"></i>',
					['action' => 'edit', $el['id']],
					[
						'escape' => false,
						'class' => 'float-right',
						'title' => __('Edit'),
						'data-tooltip' => '',
					]
				);
				$deleteLink = $this->Form->postLink(
					'<i class="far fa-fw fa-trash-alt"></i>',
					['action' => 'delete', $el['id']],
					[
						'escape' => false,
						'class' => 'float-right',
						'title' => __('Delete'),
						'data-tooltip' => '',
						'confirm' => __('Are you sure you want to delete # {0}?', $el['id']),
					]
				);

				if(!empty($el['icon'])) {
					echo '<i class="fa-fw ' . $el['icon'] . '"></i> ' . $el['title'] . $deleteLink . $editLink;
				} else {
					echo $el['title'] . $deleteLink . $editLink;
				}
				echo '</div>' . "\n";

				if(isset($el['children'])) {
					$this->navTree($el['children'], $level + 1);
				}
				echo '</li>' . "\n";
			}
		}

		echo '</ol>' . "\n";
	}

	/**
	 * generate navigation for frontend
	 * 
	 * @param  array  $array
	 * @return HTML for frontend
	 */
	public function generateNavigation(array $array, $paramController = null, $paramAction = null, $paramPass0 = null, $level = 0)
	{
		$i = 0;
		foreach($array as $el) {
			
			switch($level) {
				case 0:
					echo ($i > 0) ? '<hr class="sidebar-divider">' : '';
					if($el['icon']) {
						echo '<div class="sidebar-heading"><i class="fa-fw ' . $el['icon'] . '"></i> ' . $el['title'] . '</div>' . "\n";
					} else {
						echo '<div class="sidebar-heading">' . $el['title'] . '</div>' . "\n";
					}

					// check for children
					if(isset($el['children'])) {
						$this->generateNavigation(
							$el['children'],
							$paramController,
							$paramAction,
							$paramPass0,
							$level + 1
						);
					}
					break;
				case 1:
					if(!isset($el['children'])) {
						// is array (after decoding) = cakephp link
						if(is_array(@unserialize($el['link']))) {
							$link_arr = unserialize($el['link']);
							($link_arr['pass0']) ? $pass0 = $link_arr['pass0'] : $pass0 = false;
							($link_arr['pass1']) ? $pass1 = $link_arr['pass1'] : $pass1 = false;

							$active = '';
							if($paramController == ucfirst($link_arr['controller']) && $paramAction == $link_arr['action']) {
								if(!empty($paramPass0)) {
									if($paramPass0 == $pass0) {
										$active = ' active';
									} else {
										$active = '';
									}
								} else {
									$active = ' active';
								}
							}

							echo '<li class="nav-item' . $active . '">' . "\n";
							echo $this->Html->link(
								'<i class="fa-fw ' . $el['icon'] . '"></i> <span>' . $el['title'] . '</span>',
								[
									'controller' => $link_arr['controller'],
									'action' => $link_arr['action'],
									$pass0,
									$pass1
								],
								[
									'escape' => false,
									'class' => 'nav-link'
								]
							);
							echo '</li>' . "\n";
						}

						// is string = external link
						else {
							echo '<li class="nav-item">' . "\n";
							echo $this->Html->link(
							'<i class="fa-fw ' . $el['icon'] . '"></i> <span>' . $el['title'] . '</span>',
								$el['link'],
								[
									'escape' => false,
									'class' => 'nav-link',
									'target' => '_blank'
								]
							);
							echo '</li>' . "\n";
						}

					} else {
						if($el['link']) {
							$link_arr = @unserialize($el['link']);
							($link_arr['pass0']) ? $pass0 = $link_arr['pass0'] : $pass0 = false;
							($link_arr['pass1']) ? $pass1 = $link_arr['pass1'] : $pass1 = false;

							$expanded = 'false';
							$show = '';
							$collapsed = ' collapsed';
							$active = '';
							if($paramController == ucfirst($link_arr['controller']) && $paramAction == $link_arr['action']) {
								if(!empty($paramPass0)) {
									if($paramPass0 == $pass0) {
										$expanded = 'true';
										$show = ' show';
										$active = ' active';
										$collapsed = '';
									} else {
										$expanded = '';
										$show = '';
										$active = '';
										$collapsed = ' collapsed';
									}
								} else {
									$expanded = 'true';
									$show = ' show';
									$active = ' active';
									$collapsed = '';
								}
							}
						}

						$uniqid = uniqid();
						echo '<li class="nav-item">';
						echo '	<a class="nav-link'.$collapsed.'" href="#" data-toggle="collapse" data-target="#collapse-'.$uniqid.'" aria-expanded="'.$expanded.'" aria-controls="collapse-'.$uniqid.'">';
						echo '		<i class="fa-fw '. $el['icon'] .'"></i>';
						echo '		<span>' . $el['title'] . '</span>';
						echo '	</a>';
						echo '	<div id="collapse-'.$uniqid.'" class="collapse'.$show.'" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">';
						echo '		<div class="bg-white py-2 collapse-inner rounded">';
						
						// if current has valid link
						if($el['link']) {
							echo $this->Html->link(
								'<i class="fa-fw ' . $el['icon'] . '"></i> ' . $el['title'],
								[
									'controller' => $link_arr['controller'],
									'action' => $link_arr['action'],
									$pass0,
									$pass1
								],
								[
									'escape' => false,
									'class' => 'collapse-item' . $active
								]
							);
						}

						// call children
						$this->generateNavigation($el['children'], $paramController, $paramAction, $paramPass0, $level + 1);
						echo '		</div>';
						echo '	</div>';
						echo '</li>';
						
					}
					break;
				case 2:
					// is array (after decoding) = cakephp link
					if(is_array(@unserialize($el['link']))) {
						$link_arr = unserialize($el['link']);
						($link_arr['pass0']) ? $pass0 = $link_arr['pass0'] : $pass0 = false;
						($link_arr['pass1']) ? $pass1 = $link_arr['pass1'] : $pass1 = false;

						$active = '';
						if($paramController == ucfirst($link_arr['controller']) && $paramAction == $link_arr['action']) {
							if(!empty($paramPass0)) {
								if($paramPass0 == $pass0) {
									$active = ' active';
								} else {
									$active = '';
								}
							} else {
								$active = ' active';
							}
						}

						echo $this->Html->link(
							'<i class="fa-fw ' . $el['icon'] . '"></i> ' . $el['title'],
							[
								'controller' => $link_arr['controller'],
								'action' => $link_arr['action'],
								$pass0,
								$pass1
							],
							[
								'escape' => false,
								'class' => 'collapse-item' . $active
							]
						);
					}

					// is string = external link
					else {
						echo $this->Html->link(
							$el['title'],
							$el['link'],
							[
								'escape' => false,
								'class' => 'collapse-item',
								'target' => '_blank'
							]
						);
					}
					break;
			}
			$i++;
		}
	}
}