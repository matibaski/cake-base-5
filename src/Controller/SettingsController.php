<?php 
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;

class SettingsController extends AppController
{
	public function initialize(): void
	{
		parent::initialize();
		$this->modelClass = false;
	}

	public function settings()
	{
		$settings = \Cake\Core\Configure::read('Settings');

		if($this->request->is('post')) {
			$data = [];
			foreach($this->request->getData('Settings') as $setting) {
				$data[$setting['name']] = $setting['value'];
			}

			// create new settings file
            $write  = "<?php\n";
            $write .= "return\n";
            $write .= $this->varexport($data, true);
            $write .= ";\n?>";

            // save to file
            $file = ROOT . DS . 'config' . DS . 'settings.php';
            if(file_put_contents($file, $write)) {
                $this->Flash->success(__('The navigation has been saved.'));
            } else {
                $this->Flash->error(__('The navigation could not be saved. Please, try again.'));
            }
            return $this->redirect($this->referer());
		}

		$this->set(compact('settings'));
	}

	/**
     * varexport function
     * @param  array   $expression
     * @param  boolean $return
     * @return \Cake\Http\Response|null Outputs array to text
     */
    private function varexport(array $expression, bool $return=FALSE)
    {
        $export = var_export($expression, TRUE);
        $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
        $array = preg_split("/\r\n|\n|\r/", $export);
        $array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [NULL, ']$1', ' => ['], $array);
        $export = join(PHP_EOL, array_filter(["["] + $array));
        if ((bool)$return) return $export; else echo $export;
    }
}