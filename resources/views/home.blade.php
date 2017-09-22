<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 21/09/17
 * Time: 18:19
 */
echo 'Doctors';
echo '<br />';
echo link_to('/doctors/list', $title = 'list Doctors', $attributes = array(), $secure = null);
echo '<br />';
echo link_to('/doctors/form', $title = 'add a Doctor', $attributes = array(), $secure = null);
echo '<br />';
echo 'Pacients';
echo '<br />';
echo link_to('/pacients/list', $title = 'list Pacients', $attributes = array(), $secure = null);
echo '<br />';
echo link_to('/pacients/form', $title = 'add a Pacient', $attributes = array(), $secure = null);
