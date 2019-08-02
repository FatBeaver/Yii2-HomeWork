<?php 

use yii\helpers\Html;
use app\models\Calendar;

$this->title = 'Календарь на текущий месяц';
$this->params['breadcrumbs'][] = $this->title;


$date =  new \DateTime('01-01-2015');
?>
<div class="calendar_table">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php foreach ($years as $year): ?>
        <?php foreach ($year as $month): ?>
  
            <table border="1" class="calendar_notes">

                <tr>
                    <th>Пн</th>
                    <th>Вт</th>
                    <th>Ср</th>
                    <th>Чт</th>
                    <th>Пт</th>
                    <th>Сб</th>
                    <th>Вс</th> 
                </tr> 
                
               <?php if ($date->format('w') == 0) {
                           
                           echo '<tr>';
                                for ($i = 0; $i < 7; $i++) {
                              
                                   if ($month[$date->format('j')] != null) {
                                       
                                       $notes = count($month[$date->format('j')]);
                                       echo '<td>Событий<br/>' . $notes . '</td>';
                                   } else {
                                       echo '<td>' . $date->format('j') . '</td>';
                                   }
                                   $date->modify('+1 day'); 
                               }
                           echo '</tr>';
           
                   }
                   ///////////////////////////////////////////////////
                   if ($date->format('w') == 1) {
                                      
                       echo '<tr>';
                       echo '<td class="null_date"></td>';
                            for ($i = 0; $i < 6; $i++) {
                             
                               if ($month[$date->format('j')] != null) {
                                   
                                   $notes = count($month[$date->format('j')]);
                                   echo '<td>Событий<br/>' . $notes . '</td>';
                               } else {
                                   echo '<td>' . $date->format('j') . '</td>';
                               }
                               $date->modify('+1 day'); 
                           }
                       echo '</tr>';
           
                   }
                   //////////////////////////////////////////////////////
                   if ($date->format('w') == 2) {
                                      
                       echo '<tr>';
                       echo '<td class="null_date"></td>';
                       echo '<td class="null_date"></td>';
                            for ($i = 0; $i < 5; $i++) {
                              
                               if ($month[$date->format('j')] != null) {
                                   
                                   $notes = count($month[$date->format('j')]);
                                   echo '<td>Событий<br/>' . $notes . '</td>';
                               } else {
                                   echo '<td>' . $date->format('j') . '</td>';
                               }
                               $date->modify('+1 day'); 
                           }
                       echo '</tr>';
           
                   }
                   ////////////////////////////////
                   if ($date->format('w') == 3) {
                                      
                       echo '<tr>';
                       echo '<td class="null_date"></td>';
                       echo '<td class="null_date"></td>';
                       echo '<td class="null_date"></td>';
                            for ($i = 0; $i < 4; $i++) {
                        
                               if ($month[$date->format('j')] != null) {
                                   
                                   $notes = count($month[$date->format('j')]);
                                   echo '<td>Событий<br/>' . $notes . '</td>';
                               } else {
                                   echo '<td>' . $date->format('j') . '</td>';
                               }
                               $date->modify('+1 day'); 
                           }
                       echo '</tr>';
           
                   }
                   //////////////////////////////////////
                   if ($date->format('w') == 4) {
                                      
                       echo '<tr>';
                       echo '<td class="null_date"></td>';
                       echo '<td class="null_date"></td>';
                       echo '<td class="null_date"></td>';
                       echo '<td class="null_date"></td>';
                            for ($i = 0; $i < 3; $i++) {
           
                               if ($month[$date->format('j')] != null) {
                                   
                                   $notes = count($month[$date->format('j')]);
                                   echo '<td>Событий<br/>' . $notes . '</td>';
                               } else {
                                   echo '<td>' . $date->format('j') . '</td>';
                               }
                               $date->modify('+1 day'); 
                           }
                       echo '</tr>';
           
                   }
                   //////////////////////////////////////
                   if ($date->format('w') == 5) {
                                      
                       echo '<tr>';
                       echo '<td class="null_date"></td>';
                       echo '<td class="null_date"></td>';
                       echo '<td class="null_date"></td>';
                       echo '<td class="null_date"></td>';
                       echo '<td class="null_date"></td>';
                            for ($i = 0; $i < 2; $i++) {
                            
                               if ($month[$date->format('j')] != null) {
                                   
                                   $notes = count($month[$date->format('j')]);
                                   echo '<td>Событий<br/>' . $notes . '</td>';
                               } else {
                                   echo '<td>' . $date->format('j') . '</td>';
                               }
                               $date->modify('+1 day'); 
                           }
                       echo '</tr>';
           
                   }
                   //////////////////////////////////
                   if ($date->format('w') == 6) {
                                      
                       echo '<tr>';
                       echo '<td class="null_date"></td>';
                       echo '<td class="null_date"></td>';
                       echo '<td class="null_date"></td>';
                       echo '<td class="null_date"></td>';
                       echo '<td class="null_date"></td>';
                       echo '<td class="null_date"></td>';
                            for ($i = 0; $i < 1; $i++) {
                                
                               if ($month[$date->format('j')] != null) {
                                   
                                   $notes = count($month[$date->format('j')]);
                                   echo '<td>Событий<br/>' . $notes . '</td>';
                               } else {
                                   echo '<td>' . $date->format('j') . '</td>';
                               }
                               $date->modify('+1 day'); 
                           }
                       echo '</tr>';
                   } ?>
                
                <?php for ($k = 0; $k < 4; $k++): ?> 

                    <tr>
                <?php   for ($i = 0; $i < 7; $i++) {
                            if ( ( ( ($date->format('j')) == 28) && (($date->format('n')) == 2 ) ) ) {
                                break;
                            } 
                
                            if ($month[$date->format('j')] != null) {
                                   
                                $notes = count($month[$date->format('j')]);
                                echo '<td>Событий<br/>' . $notes . '</td>';
                            } else {

                                echo '<td>' . $date->format('j') . '</td>';
                            } 
                            $date->modify('+1 day');      
                        }?>
                    </tr>
                   
                <?php endfor; ?>

            </table>  

        <?php endforeach; ?>
    <?php endforeach; ?>
</div>