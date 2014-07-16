function thanks_top_contrib($max)
{
	$max += 2;
	$sql = "select count(*) as count,pname,nickname,email,webpage from rpm_file left join rpm_person on rpm_file.pid=rpm_person.pid " .
		"where fname like '%.rpm' and fname not like '%src%' and fname not like '%source%' group by rpm_file.pid order by count desc limit $max";
	$list = get_table_num($sql);

	echo "Rich ({$list[0]['count']}) &amp; ";
	echo "Chris ({$list[1]['count']}), blah blah";

	echo "<h1>Top Ten</h1>";
	echo "<table border='1' cellspacing='0' cellpadding='3'>";
	echo "<tr>";
	echo "<th>Count</th>";
	echo "<th>Name</th>";
	echo "<th>Email</th>";
	echo "</tr>";

	for ($i = 2; $i < $max; $i++) {
		$line = $list[$i];
		echo "<tr>";
		echo "<td>" . $line['count'] . "</td>";
		echo "<td>" . get_name($line) . "</td>";
		echo "<td><a href='mailto:" . $line['email'] . "'>" . $line['email'] . "</a></td>";
		echo "</tr>";
	}

	echo "</table>";
}

