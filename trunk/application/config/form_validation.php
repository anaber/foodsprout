<?php
$config = array(
    'photo' => array(
        'title' => array(
            'field'=>'title',
            'label'=>'Title',
            'rules'=>'trim|required'
        ),
        'status' => array(
            'field'=>'status',
            'label'=>'Status',
            'rules'=>'required'
        ),
        'item' => array(
            'field'=>'item',
            'label'=>'Item',
            'rules'=>'required'
        ),
        'description'=>array(
            'field'=>'description',
            'label'=>'Description',
            'rules'=>'trim'
        ),
    )
);
