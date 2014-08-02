<?php

echo View::make('includes/header',$data);
echo View::make($data['template'],$data);
echo View::make('includes/footer',$data);
