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
                            <a href = "contacts.php"> 
                                <img src = "imagens/portugal.png" alt = "portuguese"> 
                            </a> 
                        </li>
                        <li> 
                            <a href = "contacten.php"> 
                                <img src = "imagens/united-kingdom.png" alt = "english"> 
                            </a> 
                        </li>
                        </b>
                    </ul>
                </div>
            </div>

            <div class = "col-12 col-s-12 organizador">
                <h1 id = "organizador">
                    <p style = text-align:center> 
                        <b>
                            Organizadores 
                            <br/>   
                        </b>
                    </p> 
                </h1>

                <div class = "col-6 col-s-6 descr_organizador">
                    <center>
                        <a href = "https://www.linkedin.com/in/guilherme2006/">
                            <img src = "imagens/guilherme.png"> <p>
                        </a>
                        Guilherme Fernandes <br>
                        GPSI21 <br>
                        EPB Braga
                    </center>
                </div>

                <div class = "col-6 col-s-6 descr_organizador">
                    <center>
                        <a href = "https://www.linkedin.com/in/magda-pereira-8773b82a8/">
                            <img src = "imagens/magda.png"> <p>
                        </a>    
                        Magda Pereira <br>
                        SEC21 <br>
                        EPB Braga
                    </center>
                </div>
            </div>
            
            <div class = "col-12 col-s-12 form">
                <?php 
            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\SMTP;
            use PHPMailer\PHPMailer\Exception;

require_once 'login.php';
$ligacao = new mysqli($hn, $un, $pw, $db);

mysqli_set_charset($ligacao, "utf8");
if ($ligacao->connect_error) die("Erro Fatal");

if (isset($_POST['nome']) &&
    isset($_POST['apelido']) &&
    isset($_POST['email']) &&
    isset($_POST['mensagem']) &&
    isset($_POST['epb']) &&
    isset($_POST['curso'])) {

    // Retrieve and sanitize POST data
    $nome = get_post($ligacao, 'nome');
    $apelido = get_post($ligacao, 'apelido');
    $email = get_post($ligacao, 'email');
    $mensagem = get_post($ligacao, 'mensagem');
    $epb = get_post($ligacao, 'epb');
    $curso = get_post($ligacao, 'curso');

    // Specify column names in the INSERT query
    $query = "INSERT INTO techweek (nome, apelido, email, mensagem, epb, curso) VALUES ('$nome', '$apelido', '$email', '$mensagem', '$epb', '$curso')";
    $result = $ligacao->query($query);

    if (!$result) {
        echo "<script>alert('Ocurreu um erro e o formulário não foi enviado!')</script>";
    } 

    if ($result) {

        echo "<script>alert('Formulário enviado com sucesso !')</script>";

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
            $mail->Subject = 'Formulário Preenchido!';
            $mail->Body    = "O utilizador <b>$nome</b> preencheu o formulário! <br> A mensagem do utilizador é '$mensagem'.";
            $mail->AltBody = "O utilizador <b>$nome</b> preencheu o formulário! <br> A mensagem do utilizador é '$mensagem'.";

            $mail->send();
        } catch (Exception $e) {
            echo "";
        }
    }
}

	$nomeErr = $apelidoErr = $emailErr = $mensagemErr = $epbErr = "";

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

    	if (empty($_POST["apelido"])) {
        	$apelidoErr = "Por favor, preencha o nome.";
    	} 
		else {
    		$apelido = test_input($_POST["apelido"]);
//Verifica se o apelido só contem letras e espaços em branco
        	if (!preg_match("/[a-zA-Z ]/", $apelido)) {
            	$apelidoErr = "Só é permitido letras e espaços em branco";
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

    	if (empty($_POST["mensagem"])) {
        	$mensagemErr = "Por favor, preencha a mensagem.";
    	} 
		else {
        	$mensagem = test_input($_POST["mensagem"]);
    	}

    	if (empty ($_POST["epb"])) {
        	$epbErr = "Por favor, preencha o questionário.";
    	} 
    	else {
        	$epb = test_input($_POST["epb"]);
    	}

    	if (empty($_POST["curso"])) {
        	$curso = "";
    	} 
		else {
        	$curso = test_input($_POST["curso"]);
    	}
	}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
	
echo <<<_END
<form method="post" autocomplete="off"><pre><center><b><h1> Contacte-nos </h1>
<h3>
Nome:<span class = "error"> * </span><input type = "text" name = "nome" maxlength = "35" value = "" required> 
<span class="error">  $nomeErr</span>


Apelido:<span class = "error"> * </span><input type = "text" name = "apelido" maxlength = "35" value = "" required>
<span class = "error">  $apelidoErr</span>


Email:<span class = "error"> * </span><input type = "email" name = "email" maxlength = "100" value = "" required>
<span class = "error">  $emailErr</span>


Mensagem:<span class = "error"> * </span> <br/> 
<textarea name = "mensagem" rows = "5" cols = "40" maxlength = "250" value = "" required></textarea>
<span class = "error">  $mensagemErr</span>


Pertences à EPB?<span class = "error"> * </span> <input type = "radio" name = "epb" value = "sim" required> Sim   <input type = "radio" name = "epb" value = "não" required>  Não
<span class = "error"> $epbErr</span>


Se sim, diz me o teu curso e o teu ano! <br> 
<input type = "text" name = "curso" maxlength = "20" value = "">


<input type="submit" name = "submit" value="Submeter">

</b> </h3>	
</center></pre>
</form>
_END;


function get_post($ligacao, $var){
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
    </body>
</html>