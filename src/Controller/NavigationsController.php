<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;

/**
 * Navigations Controller
 *
 * @property \App\Model\Table\NavigationsTable $Navigations
 *
 * @method \App\Model\Entity\Navigation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NavigationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            // get settings
            $currentNavigation = \Cake\Core\Configure::read('Navigation');

            // new order
            $newOrder = json_decode($this->request->getData('order'), true);
            $write  = "<?php\n";
            $write .= "return\n";
            $write .= $this->varexport($newOrder, true);
            $write .= "\n?>";

            // save to file
            $file = ROOT . DS . 'config' . DS . 'navigation.php';
            if(file_put_contents($file, $write)) {
                $this->Flash->success(__('The navigation has been saved.'));
            } else {
                $this->Flash->error(__('The navigation could not be saved. Please, try again.'));
            }

            return $this->redirect($this->referer());
        }

        // get current navigation
        $currentNavigation = \Cake\Core\Configure::read('Navigation');

        // new order
        $navigations = $this->Navigations->find('all')->toList();

        // reduce to one level array
        $co = [];
        $co = $this->flattenArray($currentNavigation, $co, 'children');

        // remove already shown elements from database output
        $navigations = $this->compareArraysAndRemoveExsting($navigations, $co);

        $this->set(compact('navigations'));
    }

    /**
     * View method
     *
     * @param string|null $id Navigation id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $navigation = $this->Navigations->get($id, [
            'contain' => ['ParentNavigations', 'ChildNavigations'],
        ]);

        $this->set('navigation', $navigation);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $navigation = $this->Navigations->newEmptyEntity();
        if ($this->request->is('post')) {

            $data = $this->request->getData();
            
            if($data['link_type'] == 'link_type_cake') {
                unset($data['link_type'], $data['link']['url']);
                if(empty($data['link']['controller'])) {
                    $data['link'] = null;
                } else {
                    $data['link'] = serialize($data['link']);
                }
            } else {
                unset($data['link_type'], $data['link']['controller'], $data['link']['action'], $data['link']['pass0'], $data['link']['pass1']);
                $data['link'] = $data['link']['url'];
                if(empty($data['link'])) {
                    $data['link'] = null;
                }
            }

            if(empty($data['icon'])) {
                $data['icon'] = null;
            }

            $navigation = $this->Navigations->patchEntity($navigation, $data);
            if ($this->Navigations->save($navigation)) {
                $this->Flash->success(__('The navigation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The navigation could not be saved. Please, try again.'));
        }
        $parentNavigations = $this->Navigations->find('list', ['limit' => 200]);
        $this->set(compact('navigation', 'parentNavigations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Navigation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $navigation = $this->Navigations->get($id, [
            'contain' => [],
        ]);


        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['id'] = $id;
            if($data['link_type'] == 'link_type_cake') {
                unset($data['link_type'], $data['link']['url']);
                if(empty($data['link']['controller'])) {
                    $data['link'] = null;
                } else {
                    $data['link'] = serialize($data['link']);
                }
            } else {
                unset($data['link_type'], $data['link']['controller'], $data['link']['action'], $data['link']['pass0'], $data['link']['pass1']);
                $data['link'] = $data['link']['url'];
                if(empty($data['link'])) {
                    $data['link'] = null;
                }
            }

            if(empty($data['icon'])) {
                $data['icon'] = null;
            }

            $navigation = $this->Navigations->patchEntity($navigation, $data);
            if ($this->Navigations->save($navigation)) {

                $currentNavigation = \Cake\Core\Configure::read('Navigation');
                if($this->in_array_r($id, $currentNavigation)) {
                    $keyPath = $this->array_searchRecursive($id, $currentNavigation);
                    $newKeyPath = [];
                    foreach($keyPath as $path) {
                        if(is_integer($path)) {
                            array_push($newKeyPath, $path);
                        }
                    }
                    array_pop($keyPath);
                    $keyPath = implode('->', $keyPath);
                    $this->array_update_recursive($keyPath, $currentNavigation, $data);

                    // new order
                    $write  = "<?php\n";
                    $write .= "return\n";
                    $write .= $this->varexport($currentNavigation, true);
                    $write .= "\n?>";

                    // save to file
                    $file = ROOT . DS . 'config' . DS . 'navigation.php';
                    if(file_put_contents($file, $write)) {
                        $this->Flash->success(__('The navigation item has been updated.'));
                    } else {
                        $this->Flash->error(__('Updated in database, but could not update current navigation.'));
                    }
                } else {
                    $this->Flash->success(__('The navigation item has been updated.'));
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The navigation could not be saved. Please, try again.'));
        }
        $parentNavigations = $this->Navigations->find('list', ['limit' => 200]);
        $this->set(compact('navigation', 'parentNavigations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Navigation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $navigation = $this->Navigations->get($id);

        if ($this->Navigations->delete($navigation)) {
            $currentNavigation = \Cake\Core\Configure::read('Navigation');
            if($this->in_array_r($id, $currentNavigation)) {
                $keyPath = $this->array_searchRecursive($id, $currentNavigation);
                $newKeyPath = [];
                foreach($keyPath as $path) {
                    if(is_integer($path)) {
                        array_push($newKeyPath, $path);
                    }
                }
                array_pop($keyPath);
                $keyPath = implode('->', $keyPath);
                
                $this->array_unset_recursive($keyPath, $currentNavigation);

                // new order
                $write  = "<?php\n";
                $write .= "return\n";
                $write .= $this->varexport($currentNavigation, true);
                $write .= "\n?>";

                // save to file
                $file = ROOT . DS . 'config' . DS . 'navigation.php';
                if(file_put_contents($file, $write)) {
                    $this->Flash->success(__('The navigation has been deleted.'));
                } else {
                    $this->Flash->error(__('Deleted from database, but could not remove from current navigation.'));
                }

                return $this->redirect($this->referer());
            }
        } else {
            $this->Flash->error(__('The navigation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * array_unset_recursive function
     * @param  string $str
     * @param  array  &$arr
     * @return \Cake\Http\Response|null Returns array with deleted element.
     */
    private function array_unset_recursive(string $str, array &$arr)
    {
        $nodes = explode("->", $str);
        $prevEl = NULL;
        $el = &$arr;
        foreach ($nodes as &$node)
        {
            $prevEl = &$el;
            $el = &$el[$node];
        }
        if ($prevEl !== NULL)
            unset($prevEl[$node]);
        return $arr;
    }


    private function array_update_recursive(string $str, array &$arr, $replaceValue)
    {
        $nodes = explode("->", $str);
        $prevEl = NULL;
        $el = &$arr;
        foreach ($nodes as &$node)
        {
            $prevEl = &$el;
            $el = &$el[$node];
        }
        if ($prevEl !== NULL) {
            if(isset($prevEl[$node]['children'])) {
                $replaceValue['children'] = $prevEl[$node]['children'];
                $prevEl[$node] = $replaceValue;
            } else {
                $prevEl[$node] = $replaceValue;
            }
        }
        return $arr;
    }

    /**
     * [array_searchRecursive description]
     * @param  string  $needle
     * @param  array   $haystack
     * @param  boolean $strict
     * @param  array   $path
     * @return \Cake\Http\Response|null Returns keypath
     */
    private function array_searchRecursive($needle, $haystack, $strict=false, $path=array())
    {
        if(!is_array($haystack)) {
            return false;
        }
     
        foreach($haystack as $key => $val) {
            if(is_array($val) && $subPath = $this->array_searchRecursive($needle, $val, $strict, $path)) {
                $path = array_merge($path, array($key), $subPath);
                return $path;
            } elseif((!$strict && $val == $needle) || ($strict && $val === $needle)) {
                $path[] = $key;
                return $path;
            }
        }
        return false;
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

    /**
     * flattenArray method
     * @param  array  $array
     * @param  array  &$flatArray
     * @param  string $children
     * @return \Cake\Http\Response|null Returns array if successful
     */
    private function flattenArray(array $array, array &$flatArray, string $children = 'children')
    {
        foreach($array as $lvl1) {
            if(isset($lvl1[$children])) {
                $this->flattenArray($lvl1[$children], $flatArray, $children);
                unset($lvl1[$children]);
            }
            $flatArray[] = $lvl1;
        }

        return $flatArray;
    }

    /**
     * compareArraysAndRemoveExsting method
     * @param  array  $array1
     * @param  array  $array2
     * @return \Cake\Http\Response|null Returns array if successful
     */
    private function compareArraysAndRemoveExsting(array $array1, array $array2)
    {
        $outputArray = $array1;

        foreach($array1 as $a1key => $a1val) {
            foreach($array2 as $a2val) {
                if($a1val->id == $a2val['id']) {
                    unset($outputArray[$a1key]);
                }
            }
        }

        return $outputArray;
    }

    /**
     * in_array_r method
     * @param  string  $needle
     * @param  array   $haystack
     * @param  boolean $strict
     * @return \Cake\Http\Response|null Returns true if successful
     */
    private function in_array_r(string $needle, array $haystack, bool $strict = false)
    {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }
}
