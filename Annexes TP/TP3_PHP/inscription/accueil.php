<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8"/>
<title>TP PHP - Inscription d'employés</title>
</head>
<body style="background-color: #ffcc00;">
    <a href="./employee_form.php">Employés</a>

    <?php 
        $start = <<<HEREDOC
            <table style="border: black solid 1px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: black solid 1px; text-align: center;">Name</th>
                </tr>
            </thead>
            <tbody>
        HEREDOC;
        echo $start;

        $csv_filename = 'employees.csv';

        // On ouvre le csv
        $csv_file = fopen($csv_filename, 'r');

        // On ittere sur chaque ligne du csv
        while (($row = fgetcsv($csv_file, separator:";")) !== FALSE){
            $nom = $row[1];
            $age = $row[3];

            $cellule_html = <<<HEREDOC
                        <tr>
                            <td style="border: black solid 1px; text-align: center;"><a href="get__employee.php?name=$nom&age=$age">$nom</a></td>
                        </tr>
                        HEREDOC;
            echo $cellule_html;
        }

        $end = <<<HEREDOC
                    </tbody>
                </table>
                HEREDOC;

        echo $end;
    ?>
    
</body>
</html>
