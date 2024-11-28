<?php 
session_start();  

// Array soal matematika dengan beberapa pilihan jawaban (A sampai E)
$soal = [
    "hasil dari 5 + 3 =..." => ["A" => "8", "B" => "7", "C" => "6", "D" => "5", "E" => "4"],
    "hasil dari -10 + (-4) =..." => ["A" => "-14", "B" => "7", "C" => "8", "D" => "9", "E" => "10"],
    "hasil dari 7 + (-13) =..." => ["A" => "-6", "B" => "7", "C" => "6", "D" => "3", "E" => "10"],
    "hasil dari -20 + 14 =..." => ["A" => "-6", "B" => "4", "C" => "1", "D" => "12", "E" => "6"],
    "hasil dari -6 - (-7) =..." => ["A" => "1", "B" => "14", "C" => "15", "D" => "16", "E" => "17"],
    "hasil dari -15 -(-6) =..." => ["A" => "-9", "B" => "10", "C" => "8", "D" => "11", "E" => "12"],
    "hasil dari 9 - 1 =..." => ["A" => "8", "B" => "1", "C" => "0", "D" => "10", "E" => "11"],
    "hasil dari -8 - 5 =..." => ["A" => "-13", "B" => "5", "C" => "1", "D" => "6", "E" => "7"],
    "hasil dari 8 - 2 =..." => ["A" => "6", "B" => "5", "C" => "11", "D" => "12", "E" => "13"],
    "hasil dari -18 + 3 =..." => ["A" => "-15", "B" => "16", "C" => "17", "D" => "18", "E" => "19"]
];  

$kunci_jawaban = [
    "hasil dari 5 + 3 =..." => "A",
    "hasil dari -10 + (-4) =..." => "A",
    "hasil dari 7 + (-13) =..." => "A",
    "hasil dari -20 + 14 =..." => "A",
    "hasil dari -6 - (-7) =..." => "A",
    "hasil dari -15 -(-6) =..." => "A",
    "hasil dari 9 - 1 =..." => "A",
    "hasil dari -8 - 5 =..." => "A",
    "hasil dari 8 - 2 =..." => "A",
    "hasil dari -18 + 3 =..." => "A"
];

// Inisialisasi sesi untuk pertama kali
if (!isset($_SESSION['soal_acak'])) {     
    $_SESSION['soal_acak'] = array_keys($soal);     
    shuffle($_SESSION['soal_acak']);     
    $_SESSION['current_soal'] = 0;     
    $_SESSION['jawaban_pengguna'] = array_fill(0, count($_SESSION['soal_acak']), null);     
    $_SESSION['skor'] = 0; 
}

// Jika form disubmit (untuk menavigasi ke soal selanjutnya/sebelumnya)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {     
    $current_soal_index = $_SESSION['current_soal'];     
    if (isset($_POST['jawaban'])) {         
        $_SESSION['jawaban_pengguna'][$current_soal_index] = $_POST['jawaban'];     
    }      

    if (isset($_POST['next'])) {         
        if ($_SESSION['current_soal'] < count($soal) - 1) {             
            $_SESSION['current_soal']++;         
        }     
    } elseif (isset($_POST['prev'])) {         
        if ($_SESSION['current_soal'] > 0) {             
            $_SESSION['current_soal']--;         
        }     
    } elseif (isset($_POST['jump'])) {         
        $_SESSION['current_soal'] = intval($_POST['jump']);     
    } elseif (isset($_POST['submit'])) {         
        foreach ($_SESSION['soal_acak'] as $index => $soal_key) {             
            if ($_SESSION['jawaban_pengguna'][$index] == $kunci_jawaban[$soal_key]) {                 
                $_SESSION['skor']++;             
            }         
        }          
        echo "<h2>Hasil:</h2>";         
        echo "Anda menjawab benar " . $_SESSION['skor'] . " dari " . count($soal) . " soal.<br>";         
        session_destroy();         
        exit();     
    } 
}  

$current_soal_index = $_SESSION['current_soal']; 
$soal_sekarang = $_SESSION['soal_acak'][$current_soal_index]; 
?>  

<!DOCTYPE html> 
<html>
 <head>
  <title>
   Matematika
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>     
    <style>
        body {
            background-color: #f7f6fb;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            color: #333;
        }

        .content {
            background-color: #ffffff;
            padding: 20px;
            margin: 40px auto;
            border-radius: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
            width: 70%;
        }

        .content h1 {
            text-align: center;
            color: #0073e6;
        }

        .content h3 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .content form {
            font-size: 16px;
            line-height: 1.6;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #0073e6;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:disabled {
            background-color: #ccc;
        }

        input[type="submit"]:hover {
            background-color: #005bb5;
        }
        nav {
            position: sticky;
            position: -webkit-sticky;
            top: 0;
            background-color: aliceblue;
            z-index: 1;
            border-bottom: 1px solid rgb(3, 3, 3);
        }

        .sidebar {
            position: fixed;
            top: 100px; /* Adjusted from 20px to 100px to move it down */
            right: 20px;
            width: 220px;
            background-color: #f0f8ff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }


        .sidebar h2 {
            color: #0073e6;
            text-align: center;
        }

        .question-block {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            margin: 5px;
            color: white;
            background-color: #0073e6;
            border-radius: 50%;
            cursor: pointer;
        }

        .answered {
            background-color: #28a745;
        }

        .unanswered {
            background-color: #6c757d;
        }

        .question-block:hover {
            background-color: #005bb5;
        }

        .question-row {
            text-align: center;
        }
    </style>
</head> 
<body class="bg-gray-100">
  <!-- Header -->
  <nav class="bg-white shadow-md">
    <div class="container mx-auto px-4 py-2 flex justify-between items-center">
     <a class="text-2xl font-bold text-green-500" href="#">
      MATEMATIKA
     </a>
     <ul class="flex space-x-6"; text-align="right">
      <li>
       <a class="text-gray-700" href="Home.html" >
        Home
       </a>
      </li>
      <li>
       <a class="text-gray-700" href="materi.html">
        Materi
       </a>
      </li>
      <li>
       <a class="text-gray-700" href="tugas.php">
        Latihan
       </a>
      </li>
     </ul>
     <a class="bg-green-500 text-white px-4 py-2 rounded" href="#">
      Get Started
     </a>
    </div>
   </nav>  
<div class="content">     
    <h1>Soal Matematika Seru!</h1>
    <h3>Ayo asah kemampuan matematika kamu dengan menjawab soal-soal di bawah ini!</h3>      
    <form method="POST" action="">         
        <b>Soal <?php echo $current_soal_index + 1; ?>:</b> <?php echo $soal_sekarang; ?><br><br>         
        <?php         
        $jawaban = $soal[$soal_sekarang];          
        foreach ($jawaban as $key => $value) {             
            $checked = ($_SESSION['jawaban_pengguna'][$current_soal_index] == $key) ? 'checked' : '';             
            echo "<input type='radio' name='jawaban' value='$key' required $checked> $key. $value<br>";         
        }         
        ?>         
        <br>          
        <input type="submit" name="prev" value="Sebelumnya" <?php if ($current_soal_index == 0) echo 'disabled'; ?>>         
        <input type="submit" name="next" value="Selanjutnya" <?php if ($current_soal_index == count($soal) - 1) echo 'disabled'; ?>>         
        <?php if ($current_soal_index == count($soal) - 1): ?>             
            <input type="submit" name="submit" value="Kirim Jawaban">         
        <?php endif; ?>     
    </form> 
</div>  

<div class="sidebar">     
    <h2>Daftar Soal</h2>  
    <form method="POST" action="">         
        <div class="question-row">             
            <?php             
            for ($i = 0; $i < 5; $i++) {                 
                if ($i < count($_SESSION['soal_acak'])) {                     
                    $class = ($_SESSION['jawaban_pengguna'][$i] !== null) ? 'answered' : 'unanswered';                     
                    echo "<button type='submit' name='jump' value='$i' class='question-block $class'>". ($i + 1) ."</button>";                 
                }             
            }             
            ?>         
        </div>         
        <div class="question-row">             
            <?php             
            for ($i = 5; $i < 10; $i++) {                 
                if ($i < count($_SESSION['soal_acak'])) {                     
                    $class = ($_SESSION['jawaban_pengguna'][$i] !== null) ? 'answered' : 'unanswered';                     
                    echo "<button type='submit' name='jump' value='$i' class='question-block $class'>". ($i + 1) ."</button>";                 
                }             
            }             
            ?>         
        </div>     
    </form> 
</div>  
<footer class="bg-white py-8">
    <div class="mt-8 text-center text-gray-600">
     <p>
      © Copyright Mentor. All Rights Reserved
     </p>
     <p>
      Designed by Pendidikan Matematika
     </p>
     <div class="mt-4">
      <a class="text-green-600 mx-2" href="#">
       <i class="fab fa-facebook-f">
       </i>
      </a>
      <a class="text-green-600 mx-2" href="#">
       <i class="fab fa-twitter">
       </i>
      </a>
      <a class="text-green-600 mx-2" href="#">
       <i class="fab fa-instagram">
       </i>
      </a>
      <a class="text-green-600 mx-2" href="#">
       <i class="fab fa-youtube">
       </i>
      </a>
      <a class="text-green-600 mx-2" href="#">
       <i class="fab fa-linkedin">
       </i>
      </a>
     </div>
    </div>
   </div>
  </footer>
</body> 
</html>