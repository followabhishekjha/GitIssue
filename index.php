<html>
	<head>
		<title>Issues Data For Repository</title>
	</head>
	<body>
	
	<center><h3>Enter a GITHUB REPOSITORY URL to retrieve ISSUE DATA</h3>
	<!--Form For Taking User Input-->
	<form name="repo">
		<input type="url" required placeholder="Please Enter Public Repository URL" name="url"/><br/><span style="color:red"><sup>*</sup>Format(e.g.):https://github.com/Shippable/support/issues<span><br/><br/>
		<input type="submit"/>
	</form>
	</center>

	<?php
	//Actual Code Starts Here
	require_once(__DIR__ . '/client/GitHubClient.php');
	if(isset($_GET['url'])&&(strlen($_GET['url'])))
	{
		//Filtering User Input to check if url is of github
		$tempUrl=stristr($_GET['url'],"github.com");
		if(strlen($tempUrl)!=0)
		{
			$arr=explode("/",$tempUrl);
			if(!(isset($arr[1])&&(strlen($arr[1])!=0)&&isset($arr[2])&&(strlen($arr[2])!=0)))
				echo "Invalid URL";
			else
			{
				$owner = $arr[1];//repository owner as in url
				$repo = $arr[2];//repository name as in url
				date_default_timezone_set('GMT');//Setting default time zone to GMT
				
				$client = new GitHubClient();//Creating a Client Object
				$r1= $client->repos->get($owner, $repo);//Getting the repository information from GITHUB
				$issue_count=$r1->getOpenIssuesCount();//Total No. of open Issues
				
				echo "<h3>Showing data for: ".$_GET['url']."</h3><br/>";
				echo "Total number of open issues: ".$issue_count;
				
				if($issue_count>0)
				{
					$client->setPage();
					$client->setPageSize($issue_count);
				}
				
				$issues = $client->issues->listIssues($owner, $repo);//Fetching all open issues
				$new=0;
				$mid=0;
				$older=0;
				/*
				//This loop is used for counting total no. of issues based on listed conditions
				*/
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
			}
				
		}
	}
	?>

	</body>
</html>