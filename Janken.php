<?php

// 40 じゃんけんを作成しよう！
// 下記の要件を満たす「じゃんけんプログラム」を開発してください。
// 要件定義
// ・使用可能な手はグー、チョキ、パー
// ・勝ち負けは、通常のじゃんけん
// ・PHPファイルの実行はコマンドラインから。
// ご自身が自由に設計して、プログラムを書いてみましょう！

const STONE = 0;
const SCISSORS = 1;
const PAPER = 2;

const HAND_TYPE = array(
    STONE => 'グー',
    SCISSORS => 'チョキ',
    PAPER => 'パー',
);

const AIKO = 0;
const WIN = 1;
const LOSE = 2;

const JUDGE_TYPE = array(
    AIKO => 'あいこです',
    WIN => 'あなたの勝ちです',
    LOSE => 'あなたの負けです',
);

const RETRY = 0;
const RESET = 1;

const RESTART = '0';
const END = '1';

function playJanken() {
    $userHand = (int)inputHand();
    $pcHand = pcHand();
    $result = judge($userHand, $pcHand);
    show($result);

    if($result === AIKO){
        return playJanken();
    }

    $answer = continueGame();
    if($answer === RETRY) {
        return playJanken($answer);
    } else if($answer === RESET) {
        echo 'ゲームを終了します' . PHP_EOL;
        return;
    }
}

function continueGame() {
    echo 'ゲームを続けますか？';
    $input = trim(fgets(STDIN));
    
    if($input === RESTART) {
        return RETRY;
    } else if($input === END) {
        return RESET;
    } else {
        return continueGame();
    }
 }

function show($result) {
    echo JUDGE_TYPE[$result] . PHP_EOL;
}

function inputHand() {
    for($i = 0; $i < 3; $i++) {
        echo $i . ":" . HAND_TYPE[$i];
    }
    echo PHP_EOL;
    echo '0,1,2の数字を入力してください。';
    $input = trim(fgets(STDIN));
    echo 'あなたの手は:' . $input . PHP_EOL;
    if(!check($input)) {
        return inputHand();
    }
    return $input;
}

function pcHand() {
    $myHand = array_rand(HAND_TYPE);
    echo 'あいての手は:' . $myHand . PHP_EOL;
    return $myHand;
}

function judge($userHand, $pcHand) {
    $judge = ($userHand - $pcHand + 3) % 3;
    return $judge;
}

function check($userHand) {
    if($userHand === '') {
        echo '数字を入力してください。' . PHP_EOL;
        return false;
    }
    if(!is_numeric($userHand)) {
        echo '数字で入力してください。' . PHP_EOL;
        return false;
    }
    if (!isset(HAND_TYPE[$userHand])) {
        echo '0,1,2の数字で入力してください。' . PHP_EOL;
        return false;
    }
    return true;
}

playJanken();


