<html>
<head>
	<title>Hello World!</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<form method="GET" action="index.php">
		<input type="hidden" id="testLoad" name="testLoad">
		<input type="submit" name="test-load" value="Test Loading all Tuples">
	</form>

	<form method="GET" action="index.php">
		<input type="hidden" id="customQuery" name="customQuery">
		<input type="submit" name="special-query" value="Perform a custom query">
	</form>

	<form method="GET" action="index.php">
		<input type="hidden" id="joinGame" name="joinGame">
		<input type="submit" name="special-query" value="Perform a query on Game and its related entities">
	</form>

	<form method="GET" action="index.php">
		<input type="hidden" id="gameRatings" name="gameRatings">
		<input type="submit" name="special-query" value="Get the average score of all rated games">
	</form>

	<form method="GET" action="index.php">
		<input type="hidden" id="multipleEntries" name="multipleEntries">
		<input type="submit" name="special-query" value="Get Series with Multiple Entries">
	</form>

	<form method="GET" action="index.php">
		<input type="hidden" id="popularStreamer" name="popularStreamer">
		<input type="submit" name="special-query" value="Get the most popular streamer">
	</form>

	<form method="GET" action="index.php">
		<input type="hidden" id="gameAllPlatforms" name="gameAllPlatforms">
		<input type="submit" name="special-query" value="Get games that are on all platforms">
	</form>
	<h2>CRUD Operations</h2>
	<form method="GET" action="index.php">
		<h3>Select Table:</h3>
		<select name="table">
			<option value="">--SELECT TABLE--</option>
			<option value="Members">Members</option>
			<option value="CardInfo">CardInfo</option>
			<option value="CountryInfo">CountryInfo</option>
			<option value="Streamer">Streamer</option>
			<option value="Channel">Channel</option>
			<option value="Stream">Stream</option>
			<option value="Sponsor">Sponsor</option>
			<option value="Genre">Genre</option>
			<option value="Game">Game</option>
			<option value="Series">Series</option>
			<option value="Platform">Platform</option>
			<option value="GameCompany">GameCompany</option>
			<option value="GamePublisher">GamePublisher</option>
			<option value="PlatformManufacturer">PlatformManufacturer</option>
			<option value="Rates">Rates</option>
			<option value="TypeOf">TypeOf</option>
			<option value="AvailableOn">AvailableOn</option>
			<option value="GameplayOf">GameplayOf</option>
			<option value="SubscribesTo">SubscribesTo</option>
			<option value="StreamViews">Views</option>
		</select>
		<select name="method">
			<option value="">--SELECT METHOD--</option>
			<option value="Add">Add</option>
			<option value="Update">Update</option>
			<option value="Delete">Delete</option>
      <option value="Select">Select</option>
		</select>
		<input type="submit" name="fetch-table-attrs" value="Get Table Attributes">
	</form>
	<?php
	$db_conn = NULL;
	$show_debug_alert_messages = False;
	/* AGGREGATION */
	function getGamesByRating(){
		global $db_conn;
		$query = 'SELECT gameTitle, avg(rating) FROM Game G, Rates R WHERE G.gameID = R.gameID AND rating IS NOT NULL GROUP BY G.gameID';
        echo $query;
		$result = $db_conn->query($query);
		if (!$result) {
			echo mysqli_error($db_conn);
			return;
		}
		echo "<p> Average Rating of Games </p>";
		echo "<table>";
		echo "<tr>";
		echo "<th>Game Title</th>";
		echo "<th>Average Rating</th>";
		echo "</tr>";
		while ($row = $result->fetch_assoc()) {
			echo "<tr>";
			foreach ($row as $cell) {
				echo "<td>" . $cell . "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	}

	/* AGGREGATION WITH HAVING */
	function getSeriesWithMultipleEntries(){
		global $db_conn;
		$query = "SELECT seriesName, count(S.seriesID) FROM Series S, Game G WHERE G.seriesID = S.seriesID GROUP BY S.seriesID HAVING count(S.seriesID) > 1";
        echo $query;
		$result = $db_conn->query($query);
		if (!$result){
			echo mysqli_error($db_conn);
			return;
		}
		echo "<p> Series with Multiple Entries </p>";
		echo "<table>";
		echo "<tr>";
		echo "<th>Series</th>";
		echo "<th>Number of Entries</th>";
		echo "</tr>";
		while ($row = $result->fetch_assoc()) {
			echo "<tr>";
			foreach ($row as $cell) {
				echo "<td>" . $cell . "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	}

	/* NESTED AGGREGATION */
	function getPopularStreamer(){
		global $db_conn;
		$query = "SELECT userName, channelName, sum(totalUniqueViewers) FROM Streamer S, Channel C, Stream St WHERE S.channelID = C.channelID AND C.channelID = St.channelID GROUP BY St.channelID HAVING sum(totalUniqueViewers) >= ALL(SELECT sum(St2.totalUniqueViewers) FROM Stream St2 GROUP BY St2.channelID)";
        echo $query;
		$result = $db_conn->query($query);
		if (!$result){
			echo mysqli_error($db_conn);
			return;
		}
		echo "<p> Most Popular Streamer </p>";
		echo "<table>";
		echo "<tr>";
		echo "<th>Streamer Name</th>";
		echo "<th>Channel Name</th>";
		echo "<th>Total Views Across Streams</th>";
		echo "</tr>";
		while ($row = $result->fetch_assoc()) {
			echo "<tr>";
			foreach ($row as $cell) {
				echo "<td>" . $cell . "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	}

	/* DIVISION */
	function getGameOnAllPlatforms(){
		global $db_conn;
		$query = 'SELECT gameTitle FROM Game G WHERE NOT EXISTS((SELECT P1.platformID FROM Platform P1) EXCEPT (SELECT P2.platformID FROM Platform P2, AvailableOn A WHERE P2.platformID = A.platformID AND A.gameID = G.gameID))';
		echo $query;
		$result = $db_conn->query($query);
		if (!$result) {
			echo mysqli_error($db_conn);
			return;
		}
		echo "<p> Games that are on All Platforms </p>";
		echo "<table>";
		echo "<tr>";
		echo "<th>Game Title</th>";
		echo "</tr>";
		while ($row = $result->fetch_assoc()) {
			echo "<tr>";
			foreach ($row as $cell) {
				echo "<td>" . $cell . "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	}

	function getFormForCustomQuery()
	{
		echo "<form method=\"POST\" action=\"index.php\" id=\"customQuery\">";
		echo "<input type=\"hidden\" name=\"_method\" value=\"POST\">";
		echo "<p class=\"tlab\">SELECT</p>"
		. "<input type=\"text\"name=\"SELECT\"><br/>";
		echo "<p class=\"tlab\">FROM</p>"
		. "<input type=\"text\" name=\"FROM\"><br/>";
		echo "<p class=\"tlab\">WHERE</p>"
		. "<input type=\"text\" name=\"WHERE\"><br/>";
		echo "<input type=\"submit\" name=\"custom-query\" value=\"Perform Query\"></form></div>";

	}
	function performCustomQuery()
	{
		global $db_conn;
		$whereString ="";
		if(empty($_POST['SELECT'])){
			echo "<h4 class=\"error\">SELECT is Empty</h4>";
			return;
		}
		//https://stackoverflow.com/a/19347006
		$fields = array_map('trim', explode(',', $_POST['SELECT']));
		if(empty($_POST['FROM'])){
			echo "<h4 class=\"error\">FROM is Empty</h4>";
			return;
		}
		$tables = array_map('trim', explode(',', $_POST['FROM']));
		if(!empty($_POST['WHERE'])){
			$whereString = " WHERE " . $_POST['WHERE'];
		}
		$query = "SELECT " . implode(', ', $fields) . " FROM " . implode(', ', $tables) . $whereString;
        echo $query;
		if($fields == '*'){
			$fields=[];
		}
		$result = $db_conn->query($query);
		if (!$result) {
			echo "<h4 class=\"error\">Query Error</h4>";
			echo mysqli_error($db_conn);
			return;
		}
		echo "<h4 class=\"success\">Query Successfully Performed</h4>";
		echo "<p>Results of Query " . $query . "</p>";
		echo "<table>";
		echo "<tr>";
		foreach($fields as $field){
			echo "<th>" . $field . "</th>";
		}
		echo "</tr>";
		while ($row = $result->fetch_assoc()) {
			echo "<tr>";
			foreach ($row as $cell) {
				echo "<td>" . $cell . "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	}
	function getFormForGameJoin(){
		echo "<p>SELECT *</p>";
		echo "<p>FROM Game G, Series S, GameCompany GC</p>";
		echo "<form method=\"POST\" action=\"index.php\" id=\"gameJoin\">";
		echo "<input type=\"hidden\" name=\"_method\" value=\"POST\">";
		echo "<p class=\"tlab\">WHERE</p>"
		. "<input type=\"text\" name=\"WHERE\"><br/>";
		echo "<input type=\"submit\" name=\"game-join\" value=\"Perform Query\"></form></div>";
	}
	function performGameJoin(){
		global $db_conn;
		$whereString ="";
		if(!empty($_POST['WHERE'])){
			$whereString = $_POST['WHERE'];
		}
		$query = "SELECT * FROM Game G, Series S, GameCompany GC WHERE " . $whereString;
		$result = $db_conn->query($query);
		if (!$result) {
			echo "<h4 class=\"error\">Query Error</h4>";
			echo mysqli_error($db_conn);
			return;
		}
		echo "<h4 class=\"success\">Query Successfully Performed</h4>";
		echo "<p>Results of Query " . $query . "</p>";
		echo "<table>";
		while ($row = $result->fetch_assoc()) {
			echo "<tr>";
			foreach ($row as $cell) {
				echo "<td>" . $cell . "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	}
	function getTableForInsert()
	{
		global $db_conn;
		$table_name = $_GET['table'];
		if (!$table_name) {
			return;
		}
		// Get the row names
		$query = "SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME=\"" . $table_name . "\"";
		$result = $db_conn->query($query);
		if ($result) {
			echo "<h3>Add Tuple to " . $table_name . "</h3>";
			echo "<form method=\"POST\" action=\"index.php\" id=\"insert\">";
			echo "<input type=\"hidden\" id=\"testAdd\" name=\"testAdd\" value=" . $table_name . ">";
			// HTML REST limitations workaround with https://stackoverflow.com/a/40949258
			echo "<input type=\"hidden\" name=\"_method\" value=\"POST\">";
			$firstRowName = null;
			while ($row = $result->fetch_assoc()) {
				$col_name = $row['COLUMN_NAME'];
				if ($firstRowName == null) {
					$firstRowName = $col_name;
        }
				$type = $row['DATA_TYPE'];
				if (strpos($type, "int") !== false) {
					echo "<p class=\"tlab\">" . $col_name . "</p>"
						. "<input type=\"number\" name='" . $col_name . "'><br/>";
				} else if (strpos($type, "date") !== false) {
					echo "<p class=\"tlab\">" . $col_name . "</p>"
						. "<input type=\"date\" name='" . $col_name . "'><br/>";
				} else {
					echo "<p class=\"tlab\">" . $col_name . "</p>"
						. "<input type=\"text\" name='" . $col_name . "'><br/>";
				}
			}
			echo "<input type=\"submit\" name=\"test-add\" value=\"Test Add Tuple\"></form></div>";
			renderTable($table_name);
		} else {
			echo mysqli_error($db_conn);
		}
	}
	function getTableForDelete()
	{
		global $db_conn;
		$table_name = $_GET['table'];
		if (!$table_name) {
			return;
		}
		// Get the row names
		$query = "SELECT COLUMN_NAME, DATA_TYPE, COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME=\"" . $table_name . "\"";
		$result = $db_conn->query($query);
		if (!$result) {
			echo mysqli_error($db_conn);
			return;
		}
		// Add primary keys to list
		$primary_keys = [];
		while ($row = $result->fetch_assoc()) {
			$col_name = $row['COLUMN_NAME'];
			$type = $row['DATA_TYPE'];
			$key = $row['COLUMN_KEY'];
			if (!is_null($key) && strpos($key, "PRI") !== false) {
				$primary_keys[] = [$col_name, $type];
			}
		}
		echo "<h3>Remove Tuple from " . $table_name . "</h3>";
		echo "<form method=\"POST\" action=\"index.php\" id=\"delete\">";
		echo "<input type=\"hidden\" id=\"testAdd\" name=\"remove\" value=" . $table_name . ">";
		echo "<input type=\"hidden\" name=\"_method\" value=\"DELETE\">";
		foreach($primary_keys as $primary_key){
			$col_name = $primary_key[0];
			$type = $primary_key[1];
				if (strpos($type, "int") !== false) {
					echo "<p class=\"tlab\">" . $col_name . "</p>"
						. "<input type=\"number\" name='" . $col_name . "'><br/>";
				} else if (strpos($type, "date") !== false) {
					echo "<p class=\"tlab\">" . $col_name . "</p>"
						. "<input type=\"date\" name='" . $col_name . "'><br/>";
				} else {
					echo "<p class=\"tlab\">" . $col_name . "</p>"
						. "<input type=\"text\" name='" . $col_name . "'><br/>";
				}
		}
		echo "<input type=\"submit\" name=\"test-remove\" value=\"Remove Tuple\"></form></div>";
		renderTable($table_name);
	}
	function getTableForUpdate()
	{
		global $db_conn;
		$table_name = $_GET['table'];
		if (!$table_name) {
			return;
		}
		// Get the row names
		$query = "SELECT COLUMN_NAME, DATA_TYPE, COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME=\"" . $table_name . "\"";
		$result = $db_conn->query($query);
		if (!$result) {
			echo mysqli_error($db_conn);
			return;
		}
		// Add primary keys to one list, non primary keys to another
		$primary_keys = [];
		$regular_attrs = [];
		while ($row = $result->fetch_assoc()) {
			$col_name = $row['COLUMN_NAME'];
			$type = $row['DATA_TYPE'];
			$key = $row['COLUMN_KEY'];
			if (!is_null($key) && strpos($key, "PRI") !== false) {
				$primary_keys[] = [$col_name, $type];
			} else {
				$regular_attrs[] = [$col_name, $type];
			}
		}
		echo "<h3>Update Tuple of " . $table_name . "</h3>";
		echo "<form method=\"POST\" action=\"index.php\" id=\"update\">";
		echo "<input type=\"hidden\" id=\"genericUpdate\" name=\"genericUpdate\" value=" . $table_name . ">";
		echo "<input type=\"hidden\" name=\"_method\" value=\"PATCH\">";
		echo "<h4>Primary Keys</h4>";
		foreach ($primary_keys as $primary_key) {
			$col_name = $primary_key[0];
			$type = $primary_key[1];
			if (strpos($type, "int") !== false) {
				echo "<p class=\"tlab\">" . $col_name . "</p>"
					. "<input type=\"number\" name='" . $col_name . "'><br/>";
			} else if (strpos($type, "date") !== false) {
				echo "<p class=\"tlab\">" . $col_name . "</p>"
					. "<input type=\"date\" name='" . $col_name . "'><br/>";
			} else {
				echo "<p class=\"tlab\">" . $col_name . "</p>"
					. "<input type=\"text\" name='" . $col_name . "'><br/>";
			}
		}
		echo "<h4>Attributes to Update</h4>";
		foreach ($regular_attrs as $regular_attr) {
			$col_name = $regular_attr[0];
			$type = $regular_attr[1];
			if (strpos($type, "int") !== false) {
				echo "<p class=\"tlab\">" . $col_name . "</p>"
					. "<input type=\"number\" name='" . $col_name . "'><br/>";
			} else if (strpos($type, "date") !== false) {
				echo "<p class=\"tlab\">" . $col_name . "</p>"
					. "<input type=\"date\" name='" . $col_name . "'><br/>";
			} else {
				echo "<p class=\"tlab\">" . $col_name . "</p>"
					. "<input type=\"text\" name='" . $col_name . "'><br/>";
			}
		}
		echo "<input type=\"submit\" name=\"update-table\" value=\"Update Tuple\"></form></div>";
		renderTable($table_name);
	}
    function getTableForSelect(){
        global $db_conn;
        $table_name = $_GET['table'];
        // Get the row names
        $query = "SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME=\"" . $table_name . "\"" ;
        $result = $db_conn->query($query);
        if ($result){
            echo "<h3>Select Attributes From " . $table_name . "</h3>";
            echo "<form method=\"GET\" action=\"index.php\" id=\"select\">";
            echo "<input type=\"hidden\" id=\"select\" name=\"select\" value=" . $table_name .">";
            $firstRowName = null;
            while ($row = $result->fetch_assoc()){
                $col_name = $row['COLUMN_NAME'];
                if ($firstRowName == null) {
                    $firstRowName = $col_name;
                }
                echo "<p class=\"tlab\">" . $col_name . "</p>"
                    . "<input type=\"checkbox\" name='" . $col_name . "'><br/>";
            }
            echo "<p class=\"tlab\">" . "WHERE" . "</p>"
                . "<input type=\"text\" name='" . "WHERE" . "'><br/>";
            echo "<input type=\"submit\" name=\"test-select\" value=\"Submit\"></form></div>";
            renderTable($table_name);
        }else{
            echo mysqli_error($db_conn);
        }
    }
	// TypeConverter that uses 2D arrays over query rows
	// Attr array expects an array with elements [col_name, type]
	// Data can be in the form of _POST
	function arrTypeConverter($attr_arr, $data)
	{
		$result = [];
		foreach ($attr_arr as $attr) {
			$col_name = $attr[0];
			$type = $attr[1];
			if (isset($data[$col_name]) && !empty($data[$col_name])) {
				if ($data[$col_name] == "NULL") {
					$result[] = $col_name . "=NULL";
				} else if (strpos($type, "int") !== false) {
					$result[] = $col_name . "=" . $data[$col_name];
				} else {
					$result[] = $col_name . "='" . $data[$col_name] . "'";
				}
			}
		}
		return $result;
	}
	

	// Generates a string of the format 'PK1=val1 AND PK2=val2 AND ... AND PKN = valN' for update queries
	function generateUpdateConds($primary_keys)
	{
		return implode(" AND ", arrTypeConverter($primary_keys, $_POST));
	}

	// Generates a string of the format 'Attr1=val1, Attr2=val2, ..., AttrN=valN' for update queries
	function generateUpdateVals($attrs)
	{
		return implode(",  ", arrTypeConverter($attrs, $_POST));
	}


	function handleUpdateRequest()
	{
		global $db_conn;
		$table_name = $_POST['genericUpdate'];
		// Fetch attribute metadata first
		$query = "SELECT COLUMN_NAME, DATA_TYPE, COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME=\"" . $table_name . "\"";
		$result = $db_conn->query($query);
		if (!$result) {
			echo mysqli_error($db_conn);
			return;
		}

		$primary_keys = [];
		$regular_attrs = [];

		while ($row = $result->fetch_assoc()) {
			$col_name = $row['COLUMN_NAME'];
			$type = $row['DATA_TYPE'];
			$key = $row['COLUMN_KEY'];
			if (!is_null($key) && strpos($key, "PRI") !== false) {
				$primary_keys[] = [$col_name, $type];
			} else {
				$regular_attrs[] = [$col_name, $type];
			}
		}

		$whereString = generateUpdateConds($primary_keys);
		$setString  = generateUpdateVals($regular_attrs);

		if ($whereString == "") {
			echo "<h4 class=\"error\">You must specify at least 1 attribute in the primary key</h4>";
			return;
		}

		if ($setString == "") {
			echo "<h4 class=\"error\">You must specify at least 1 attribute to update</h4>";
			return;
		}
		$query = "UPDATE " . $table_name . " SET " . $setString . " WHERE " . $whereString;
        echo $query;
		if ($db_conn->query($query)) {
			debugAlertMessage("POST success");
			echo "<h4 class=\"success\">PATCH Success. Updated " . $db_conn->affected_rows . " row(s)</h4>";
			renderTable($table_name);
		} else {
			debugAlertMessage("POST failure");
			echo "<h4 class=\"error\">PATCH Failure</h4>";
			echo mysqli_error($db_conn);
		}
	}

    function handleSelectRequest(){
        global $db_conn;
        $table = $_GET;
        $table_name = $_GET['select'];
        // Fetch attribute metadata first
        $keys = [];
        $selectString = "";
        $whereString = $table["WHERE"];
        foreach ($table as $row => $val) {
            if($val === "on"){
				$col_name = $row;
                if ($keys === []) {
                    $selectString = $col_name;
                } else {
                    $selectString = $selectString . ", " . $col_name; 
                }
                $keys[] = $col_name;
			}
        }
        if ($whereString != "") {
            $query = "SELECT " . $selectString . " FROM " . $table_name . " WHERE " . $whereString;
        } else {
            $query = "SELECT " . $selectString . " FROM " . $table_name;
        }
        renderSelectTable($table_name, $query, $keys);
    }

	function debugAlertMessage($message)
	{
		global $show_debug_alert_messages;

		if ($show_debug_alert_messages) {
			echo "<script type='text/javascript'>alert('" . $message . "');</script>";
		}
	}

	function connectToDB()
	{
		global $db_conn;
		$hostname = "127.0.0.1";
		if (isset($_ENV["USER"]) && $_ENV["USER"] == "docker") {
			$hostname = "mysql";
		}
		$db_conn = new mysqli($hostname, "root", "", "cs304-project");
		if ($db_conn->connect_error) {
			debugAlertMessage($db_conn->connect_error);
			return false;
		} else {
			debugAlertMessage("Connection Successful");
			return true;
		}
	}
	function disconnectFromDB()
	{
		global $db_conn;
		debugAlertMessage("Disconnect from Database");
		mysqli_close($db_conn);
	}
	function typeconverter($q, $n)
	{
		$outstring = "";
		while ($row = $q->fetch_assoc()) {
			$col_name = $row['COLUMN_NAME'];
			$type = $row['DATA_TYPE'];
			$addval = $n[$col_name];
			if ($addval === "") {
				$outstring = $outstring . ", NULL";
			} else if (strpos($type, "int") !== false) {
				$outstring = $outstring . ", " . $addval;
			} else {
				$outstring = $outstring . ", " . "\"" . $addval . "\"";
			}
		}
		return substr($outstring, 2);
	}
	function handleAddRequest()
	{
		global $db_conn;
		$table_name = $_POST;
		$query = "SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS where table_name=\"" . $table_name['testAdd'] . "\"";
		$res = $db_conn->query($query);
		$values = typeconverter($res, $table_name);

		$query = "INSERT INTO " . $table_name['testAdd'] . " VALUES (" . $values . ");";
        echo $query;
		if ($db_conn->query($query)) {
			debugAlertMessage("POST success");
			echo "<h4 class=\"success\">Post Success</h4>";
			renderTable($table_name['testAdd']);
		} else {
			debugAlertMessage("POST failure");
			echo "<h4 class=\"error\">Post Failure</h4>";
			echo mysqli_error($db_conn);
		}
	}
	function handleRemoveRequest()
	{
		global $db_conn;
		$table_name = $_POST['remove'];
		// Fetch attribute metadata first
		$query = "SELECT COLUMN_NAME, DATA_TYPE, COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME=\"" . $table_name . "\"";
		$result = $db_conn->query($query);
		if (!$result) {
			echo mysqli_error($db_conn);
			return;
		}

		$primary_keys = [];

		while ($row = $result->fetch_assoc()) {
			$col_name = $row['COLUMN_NAME'];
			$type = $row['DATA_TYPE'];
			$key = $row['COLUMN_KEY'];
			if (!is_null($key) && strpos($key, "PRI") !== false) {
				$primary_keys[] = [$col_name, $type];
			}
		}

		$whereString = generateUpdateConds($primary_keys);

		if ($whereString == "") {
			echo "<h4 class=\"error\">You must specify at least 1 attribute in the primary key</h4>";
			return;
		}
		$query = "DELETE FROM " . $table_name . " WHERE " . $whereString;

		if ($db_conn->query($query)) {
			debugAlertMessage("DELETE success");
			echo "<h4 class=\"success\">DELETE success. Deleted " . $db_conn->affected_rows . " row(s)</h4>";
			renderTable($table_name);
		} else {
			debugAlertMessage("DELETE failure");
			echo "<h4 class=\"error\">DELETE Failure</h4>";
			echo mysqli_error($db_conn);
		}
	}
	function handleLoadRequest()
	{
		global $db_conn;
		$query = file_get_contents("../mysql_scripts/CREATE.sql");
		$result = $db_conn->query($query);
	}
	function renderTable($table_name)
	{
		global $db_conn;
		$query = "SELECT * FROM " . $table_name;
		$hquery = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS where table_name=\"" . $table_name . "\"";
		$result = $db_conn->query($query);
		$headers = $db_conn->query($hquery);
		echo "<p> Current data in " . $table_name . " </p>";
		echo "<table>";
		echo "<tr>";
		while ($row = $headers->fetch_assoc()) {
			echo "<th>" . $row['COLUMN_NAME'] . "</th>";
		}
		echo "</tr>";
		while ($row = $result->fetch_assoc()) {
			echo "<tr>";
			foreach ($row as $cell) {
				echo "<td>" . $cell . "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	}
    function renderSelectTable($table_name, $q, $h){
        global $db_conn;
        $query = $q;
        echo $query;
        $result = $db_conn->query($query);
        $headers = $h;
        echo "<p> Current data in " . $table_name . " </p>";
        echo "<table>";
        echo "<tr>";
        foreach ($headers as $row){
            echo "<th>" . $row . "</th>";
        }
        echo "</tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . $cell . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
	function handleGETRequest()
	{
		if (connectToDB()) {
			if (array_key_exists('testLoad', $_GET)) {
				handleLoadRequest();
			} else if (array_key_exists('table', $_GET)) {
				if (strpos($_GET["method"], "Add") !== false) {
					getTableForInsert();
				} else if (strpos($_GET["method"], "Update") !== false) {
					getTableForUpdate();
				} else if (strpos($_GET["method"], "Delete") !== false) {
					getTableForDelete();
        } else if (strpos($_GET["method"], "Select") !== false) {
          getTableForSelect();
        }
			} else if (array_key_exists('gameAllPlatforms', $_GET)){
				getGameOnAllPlatforms();
			} else if (array_key_exists('gameRatings', $_GET)){
				getGamesByRating();
			} else if (array_key_exists('gameReadable', $_GET)){
				getVerboseGames();
			} else if (array_key_exists('popularStreamer', $_GET)){
				getPopularStreamer();
			} else if (array_key_exists('customQuery', $_GET)){
				getFormForCustomQuery();
			} else if (array_key_exists('multipleEntries', $_GET)){
				getSeriesWithMultipleEntries();
			} else if (array_key_exists('joinGame', $_GET)){
				getFormForGameJoin();
			} else if (array_key_exists('select', $_GET)) {
                handleSelectRequest();
      }
			disconnectFromDB();
		}
	}

	function handlePOSTRequest()
	{
		if (connectToDB()) {
			if(strpos($_POST['_method'], "PUT") !== false){
				handlePUTRequest();
			} else if (strpos($_POST['_method'], "PATCH") !== false){
				handlePATCHRequest();
			} else if (strpos($_POST['_method'], "DELETE") !== false){
				handleDELETERequest();
			} else{
				// Remaining requests must be POST
				if (array_key_exists('testAdd', $_POST)) {
					handleAddRequest();
				} else if(array_key_exists('custom-query', $_POST)){
					performCustomQuery();
				} else if(array_key_exists('game-join', $_POST)){
					performGameJoin();
				}
			}
			disconnectFromDB();
		}
	}

	function handlePUTRequest() {
		// Probably will not be used
	}

	function handlePATCHRequest() {
		if (array_key_exists('genericUpdate', $_POST)) {
			handleUpdateRequest();
		}
	}

	function handleDELETERequest() {
		if (array_key_exists('remove', $_POST)) {
			handleRemoveRequest();
		}
	}

	if (isset($_GET["test-load"]) || isset($_GET["fetch-table-attrs"]) || isset($_GET['special-query']) || isset($_GET["test-select"])) {
		handleGETRequest();
	}
	// if (isset($_POST["test-add"]) || isset($_POST["update-table"]) || isset($_POST["delete-tuple"])) {
	// 	handlePOSTRequest();
	// }
	if (isset($_POST["_method"])){
		handlePOSTRequest();
	}
	// phpinfo();
	?>
</body>

</html>
