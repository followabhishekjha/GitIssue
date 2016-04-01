<?php
require_once(__DIR__ . '/client/GitHubClient.php');

$owner = 'shippable';
$repo = 'support';
date_default_timezone_set('GMT');
$client = new GitHubClient();
$r1= $client->repos->get($owner, $repo);
$issue_count=$r1->getOpenIssuesCount();
echo "Total number of open issues: ".$issue_count;
$client->setPage();
$client->setPageSize($issue_count);
$issues = $client->issues->listIssues($owner, $repo);
$new=0;
$mid=0;
$older=0;
foreach ($issues as $issue)
{
	if(strtotime($issue->getCreatedAt())>(time()-24*60*60))
		$new++;
	else
		if(strtotime($issue->getCreatedAt())>(time()-7*24*60*60))
			$mid++;
		else
			$older++;
}
echo "<br/>Number of open issues that were opened in the last 24 hours: ".$new;
echo "<br/>Number of open issues that were opened more than 24 hours ago but less than 7 days ago: ".$mid;
echo "<br/>Number of open issues that were opened more than 7 days ago: ".$older;