<?php
define('SITE_KEY', '6LeBOjkaAAAAALwBdeW8uf6fHiuBROnQ7-hj2nwT');
define('SECRET_KEY', '6LeBOjkaAAAAAKIDdGOaIUa4rh5k_7O93Vif9Zvx');

If($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {

    // Build POST request:
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = '6LeBOjkaAAAAAKIDdGOaIUa4rh5k_7O93Vif9Zvx';
    $recaptcha_response = $_POST['recaptcha_response'];

    // Make and decode POST request:
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);
	$sco = $recaptcha->score;
    // Take action based on the score returned:
    if ($recaptcha->score >= 0.5) {
// Verified - send email
		$to = "ranisss.gabbasov@mail.ru"; // емайл получателя данных из формы
		$tema = "Форма обратной связи на PHP"; // тема полученного емайла
		$message = "Имя: ".$_POST['name']."<br>";//присвоить переменной значение, полученное из формы name=name
		$message .= "Номер телефона: ".$_POST['phone']."<br>"; //полученное из формы name=phone
		$message .= "E-mail: ".$_POST['email']."<br>"; //полученное из формы name=email
		$message .= "Возраст: ".$_POST['age']."<br>";
		$message .= "Дата рождения: ".$_POST['birthdate']."<br>";
		$message .= "Курс обучения: ".$_POST['mycourse']."<br>";
		$message .= "Рекомендация: ".$_POST['fitback']."<br>";
		$message .= "Комментарий: ".$_POST['message']."<br>"; //полученное из формы name=message
		$message .= "Разрешить обработку данных: ".$_POST['allow']."<br>";
		$message .= "Разрешить отправлять новости: ".$_POST['news']."<br>";
		$headers  = 'MIME-Version: 1.0' . "\r\n"; // заголовок соответствует формату плюс символ перевода строки
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; // указывает на тип посылаемого контента
		$headers .= 'X-Mailer: PHP/'.phpversion();
		$headers .= 'From: admin@variouscat.ru' . "\r\n";

mail($to, $tema, $message, $headers);
echo "Письмо отправлено успешно. Вы - человек на " . $sco*100 . "%";

        
    } else {
        // Not verified - show form error
    echo "Вы - робот на " . 100-$sco*100 . "%";	
    }

}

header ("location: http://variouscat.ru")
?>