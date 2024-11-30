<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('test:command')->hourly();
