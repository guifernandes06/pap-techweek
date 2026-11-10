<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <meta name = "description" content = "Desenvolvimento Web">
        <meta name = "keywords" content = "HTML, CSS, JavaScript">
        <meta name = "author" content = "Guilherme Fernandes">
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0">

        <link rel = "stylesheet" type = "text/css" href = "estilos.css">
        <link rel="shortcut icon" href="imagens/logo_header.png" type="imagens/svg"/>

        <title> TechWeek 2024 </title>
    </head>

    <body>
        <div class = "row">
        <div class = "col-12 col-s-12 header">
                <center>
                    <div class = "col-6 col-s-6 header_logo">
                        <a href = "index.html">
                            <img src = "imagens/logo_header.png">
                        </a>
                    </div>
                </center>

                <div class= "col-6 col-s-6 menu">
                    <ul>
                        <b>
                            <center>
                        <li>
                            <a href = "index.html" class = "a"> 
                                Home 
                            </a>
                        </li>
                        <li> 
                            <a href = "index.html#programa" class = "a">
                                Programa
                            </a>
                        </li>
                        <li> 
                            <a href = "index.html#oradores" class = "a">
                                Oradores
                            </a>
                        </li>
                        <li> 
                            <a href = "eventos.html" class = "a"> 
                                Eventos Anteriores 
                            </a> 
                        </li>
                        <li>
                            <a href = "feedback.php" class = "a">
                                Feedback
                            </a>
                        </li>
                        <li>
                            <a href = "contacts.php" class = "a">
                                Contactos
                            </a>
                        </li>
                            </center>
                        <li> 
                            <a href = "feedback.php"> 
                                <img src = "imagens/portugal.png" alt = "portuguese"> 
                            </a> 
                        </li>
                        <li> 
                            <a href = "feedbacken.php"> 
                                <img src = "imagens/united-kingdom.png" alt = "english"> 
                            </a> 
                        </li>
                        </b>
                    </ul>
                </div>
            </div>

            <div class = "col-12 col-s-12 feedback">
            <hr style = "height:2px;background-color:black"> <br>
            <?php
            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\SMTP;
            use PHPMailer\PHPMailer\Exception;

require_once 'login.php';
$ligacao = new mysqli($hn, $un, $pw, $db);

mysqli_set_charset($ligacao, "utf8");
if ($ligacao->connect_error) die("Erro Fatal");

if (isset($_POST['nome']) &&
isset($_POST['email']) &&
isset($_POST['dia']) &&
isset($_POST['orador']) &&
isset($_POST['avaliacao']) &&
isset($_POST['mensagem']) &&
isset($_POST['epb']) &&
isset($_POST['curso'])) {
	
$nome = get_post($ligacao, 'nome');
$email = get_post($ligacao, 'email');
$dia = get_post($ligacao, 'dia');
$orador = get_post($ligacao, 'orador');
$avaliacao = get_post($ligacao, 'avaliacao');
$mensagem = get_post($ligacao, 'mensagem');
$epb = get_post($ligacao, 'epb');
$curso = get_post($ligacao, 'curso');
	
// inserir registo
$query = "INSERT INTO feedback (nome, email, dia, orador, avaliacao, mensagem, epb, curso) VALUES ('$nome', '$email', '$dia', '$orador', '$avaliacao', '$mensagem', '$epb', '$curso')";
$result = $ligacao->query($query);

if ($result) {

    echo "<script>alert('Feedback enviado com sucesso !')</script>";

    require 'vendor/autoload.php';
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Habilita saída de depuração detalhada
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();                       // Envia usando SMTP
        $mail->Host       = 'smtp-mail.outlook.com';  // Define o servidor SMTP para enviar através de
        $mail->SMTPAuth   = true;              // Habilita a autenticação SMTP
        $mail->Username   = 'suporte-techweek24@outlook.pt'; // Nome de usuário SMTP
        $mail->Password   = 'TechWeek#2024'; // Senha de aplicativo SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilita criptografia TLS com STARTTLS
        $mail->Port       = 587;               // Porta TCP para conectar-se

        // Destinatários
        $mail->setFrom('suporte-techweek24@outlook.pt', 'TechWeek 2024');
        $mail->addAddress('suporte-techweek24@outlook.pt'); // Adiciona o destinatário fixo
        $mail->addReplyTo('suporte-techweek24@outlook.pt', 'TechWeek 2024');

        // Conteúdo
        $mail->isHTML(true);                   // Define o formato do email como HTML
        $mail->Subject = 'Feedback Preenchido!';
        $mail->Body    = "O utilizador <b>$nome</b> avaliou o orador <b>$orador</b>! Tendo uma avaliação de '$avaliacao'! <br> A mensagem do utilizador é '$mensagem'.";
        $mail->AltBody = "O utilizador <b>$nome</b> avaliou o orador <b>$orador</b>! Tendo uma avaliação de '$avaliacao'! <br> A mensagem do utilizador é '$mensagem'.";

        $mail->send();
    } catch (Exception $e) {
        echo "";
    }
}

}

$nomeErr = $emailErr = $diaErr = $oradorErr = $avaliacaoErr = $epbErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (empty($_POST["nome"])) {
        $nomeErr = "Por favor, preencha o nome.";
    } 
    else {
        $nome = test_input($_POST["nome"]);
//Verifica se o nome só contem letras e espaços em branco
        if (!preg_match("/[a-zA-Z ]/", $nome)) {
            $nomeErr = "Só é permitidas letras e espaços em branco";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Por favor, preencha o email.";
    } 
    else {
        $email = test_input($_POST["email"]);
// Verifica se o email está bem formatado
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Formato de email inválido.";
        }   
    }

    if (empty ($_POST["dia"])) {
        $diaErr = "Por favor, preencha o dia.";
    } 
    else {
        $dia = test_input($_POST["dia"]);
    }

    if (empty ($_POST["orador"])) {
        $oradorErr = "Por favor, diga qual é o orador.";
    } 
    else {
        $orador = test_input($_POST["orador"]);
    }

    if (empty ($_POST["avaliacao"])) {
        $avaliacaoErr = "Por favor, preencha a avaliacao.";
    } 

    if (empty($_POST["mensagem"])) {
        $mensagem = "";
    } 

    if (empty ($_POST["epb"])) {
        $epbErr = "Por favor, preencha o questionário.";
    } 

    if (empty($_POST["curso"])) {
        $curso = "";
    } 
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// _END efectua output de tudo até encontrar novo _END 
echo <<<_END
<form action = "feedback.php" method = "post" autocomplete="off"> <pre><center><b><h1> Dê-nos a sua opinião </h1>
<h3> 
Seu nome: <span class = "error">* </span> <input type = "text" name = "nome" maxlength = "35 value = "" required>
<span class = "error"> $nomeErr</span>

Seu email: <span class = "error">* </span> <input type = "email" name = "email" required>	
<span class = "error"> $emailErr</span>

Qual foi o dia da apresentação? <span class = "error">* </span> 

<input type = "radio" name = "dia" value = "18" required> 18 <input type = "radio" name = "dia" value = "19" required> 19 <input type = "radio" name = "dia" value = "21" required> 21 <input type = "radio" name = "dia" value = "22" required> 22
<span class = "error"> $diaErr</span>

Selecione o orador: <span class = "error"> * </span> <br>
    <select name = "orador" required>
<option value = "" disabled selected> </option> 

<option> Joshua Jones - Adaptação de Brinquedos </option>
<option> Ana Neves - Adaptação de Brinquedos </option>
<option> Pedro Cunha - Adaptação de Brinquedos </option>

<option> Filipe Gomes - Cibersegurança </option>

<option> João Pedro Ribeiro - Inteligência Artificial Automóvel </option>

<option> Tiago Rei - VPN </option>

<option> Tiago Barbosa - Robótica </option>

<option> Emídio Vidal - Design Web </option>
<option> Hugo Peixoto - Programação Web </option>
</select>	
<span class = "error"> $oradorErr</span>

Avalie o orador: <span class = "error">* </span> <br>
<input type = "radio" name = "avaliacao" value = "1" required> 1 <input type = "radio" name = "avaliacao" value = "2" required> 2 <input type = "radio" name = "avaliacao" value = "3" required> 3 <input type = "radio" name = "avaliacao" value = "4" required> 4 <input type = "radio" name = "avaliacao" value = "5" required> 5 
<span class = "error"> $avaliacaoErr</span>

Mensagem: 

<textarea name = "mensagem" rows = "5" cols = "40" maxlength = "250" value = "" required> </textarea>


Pertences à EPB? <span class = "error">* </span><input type = "radio" name = "epb" value = "sim" required> Sim <input type = "radio" name = "epb" value = "nao" required> Não
<span class = "error"> $epbErr</span>

Se sim, diz me o teu curso e o teu ano! <br>
<input type = "text" name = "curso">


<input type = "submit" name = "submit" value = "Submeter">
</b> </h3>	
</center></pre>
</form>
_END;

function get_post($ligacao, $var) {
return $ligacao->real_escape_string($_POST[$var]);
}
            ?>
            </div>

                <div class = "col-12 col-s-12 footer">
                
                    <div class = "col-4 col-s-4 footer_contact">
                        <h2>
                            Contacte-nos
                        </h2>
                        <h4>
                            <a href = "mailto:techweek2024@epb.pt">
                                techweek2024@epb.pt
                            </a>
                        </h4>
                    </div>

                    <div class = "col-4 col-s-4 footer_local">
                        <h2>
                            Local
                        </h2>
                        <h4>
                            <a href = "https://maps.app.goo.gl/k6Ljkm2LujtaNiWFA">
                                EPB - Braga
                            </a>
                        </h4>
                    </div>

                    <div class = "col-4 col-s-4 footer_social">
                        <h2>
                            Redes Sociais
                        </h2>
                        <a href = "https://www.facebook.com/epbtechweek?locale=pt_PT">
                            <img src = "imagens/facebook.png" alt = "facebook">
                        </a>
                        &nbsp;
                        <a href = "https://www.instagram.com/techweek24_epb?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">
                            <img src = "imagens/instagram.png" alt = "instagram">
                        </a>
                        &nbsp;
                        <a href = "https://www.youtube.com/@escolaprofissionaldebraga1814">
                            <img src = "imagens/youtube.png" alt = "youtube">
                        </a>
                    </div> 
                </div>

            </div>

        </div>
    </body>
</html>