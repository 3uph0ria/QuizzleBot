<?php

// Начинаем сессию
session_start();

// Удаляем переменные сессии
session_unset();

// Завершаем сессию
session_destroy();

header('Location: /bots-panel/');
