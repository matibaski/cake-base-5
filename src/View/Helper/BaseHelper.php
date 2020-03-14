<?php 
namespace App\View\Helper;

use Cake\View\Helper;

class BaseHelper extends Helper
{
	public $helpers = ['Html'];

	public function counterCard(string $title, $counter, $type, $prefix = '', $affix = '', $color = 'primary', $icon = 'far fa-question-circle')
	{
		echo '<div class="col-xl-3 col-md-6 mb-4">' . "\n";
		echo '<div class="card border-left-'. $color . ' shadow h-100 py-2">' . "\n";
		echo '<div class="card-body">' . "\n";
		echo '<div class="row no-gutters align-items-center">' . "\n";
		echo '<div class="col mr-2">' . "\n";
		echo '<div class="text-xs font-weight-bold text-' . $color .  ' text-uppercase mb-1">'. $title . '</div>' . "\n";
		echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'. $prefix . $counter . $affix . '</div>' . "\n";
		echo '</div>' . "\n";
		echo '<div class="col-auto">' . "\n";
		echo '<i class="'. $icon . ' fa-2x text-gray-300"></i>' . "\n";
		echo '</div>' . "\n";
		echo '</div>' . "\n";
		echo '</div>' . "\n";
		echo '</div>' . "\n";
		echo '</div>' . "\n";
	}
}