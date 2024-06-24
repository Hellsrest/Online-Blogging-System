<?php
$tasks=[
    ['learn php programming',2],
    ['lear',3],
    [' php ',4]
];
    foreach($tasks as $task){
        foreach($task as $task_detail){
            echo($task_detail."<br>");
        }   
    }
?>