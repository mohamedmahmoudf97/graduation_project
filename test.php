
<?php ob_start() ;?>
<?php session_start(); ?>

<?php include 'connection.php'?>
<?php 
include 'function.php';
$q = $_GET['q'];

$sql="SELECT
*
FROM
gra_matches
JOIN gra_team ON gra_team.gra_team_id = gra_matches.gra_matches_team_a
JOIN gra_stadium ON gra_stadium.gra_stadium_id = gra_matches.gra_matches_stadium
JOIN gra_country ON gra_country.gra_country_id = gra_stadium.gra_stadium_country
WHERE
gra_team.gra_team_name LIKE '%$q%' OR gra_stadium.gra_stadium_name LIKE '%$q%' OR gra_country.gra_country_name LIKE '$q%'
LIMIT 1";
$qgo = mysqli_query($con , $sql);
while($row = mysqli_fetch_array($qgo)){	

    echo'
    <div class="item border mb-3" >
    <div class="matche-box mx-auto bg-light text-center">
        <a href="matches.php?do=singlmatches&matcheid='.$row['gra_matches_id'].'">
            <div class="team-a float-left p-3">
                <img class="img-fluid match-img" src="'.str_replace("../", "",getmatchteamimg($row['gra_matches_team_a'])).'"/>
                <p>'.getmatchteamname($row['gra_matches_team_a']).'</p>
            </div>

            <div class="time-stad float-left p-3 mt-2">
                <p>'.$row['gra_matches_date_time'].'</p>
                <p>'.getmatchstad($row['gra_matches_stadium']).'</p>
            </div>

            <div class="team-b float-left p-3">
                <img class="img-fluid match-img" src="'.str_replace("../", "",getmatchteamimg($row['gra_matches_team_b'])).'" />
                <p>'.getmatchteamname($row['gra_matches_team_b']).'</p>
            </div>
            <div class="clr"> </div>
        </a>
    </div>
</div>
';
}




?><?php ob_end_flush() ;?>