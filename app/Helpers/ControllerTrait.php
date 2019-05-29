<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Request;

trait ControllerTrait {

    public function formValidation(Request $r, $overide = [])
    {
        $validations = [];
        foreach ($this->form() as $form) {
            if($r->isMethod('post')){
                if(array_key_exists('validation.store',$form)){
                    $validations[$form['name']] = $form['validation.store'];
                }else{
                    $validations[$form['name']] = 'required';
                }
            }elseif($r->isMethod('put')){
                if(array_key_exists('validation.update',$form)){
                    $validations[$form['name']] = $form['validation.update'];
                }else{
                    $validations[$form['name']] = 'required';
                }
            }
        }
        $validations = array_merge($validations,$overide);
        $r->validate($validations);
    }
}