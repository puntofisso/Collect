<?php
// from https://github.com/krues8dr/SpeedyDelivery/blob/master/speedydelivery.php
// collects tinyletter archive
// released originally under Apache Licence https://github.com/krues8dr/SpeedyDelivery/blob/master/LICENSE
$user = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$baseurl ="https://jobs.sgul.ac.uk";
$url = "https://jobs.sgul.ac.uk/vacancies.aspx?cat=-1";
$html_orig = file_get_contents($url);
$html = trim($html_orig);

function main($html) 
{
	global $baseurl;
	if ($html) 
	{
		$dom = new DOMDocument;
		$dom->preserveWhiteSpace = FALSE;
		$dom->loadHTML($html);
		$xpath = new DomXpath($dom);	

		$container =  $xpath->query('//*[@id="maincontentcenter"]')->item(0);
		$entries = $xpath->query('//*[@style="margin-left:15px;"]/ul',$container);
		
		$jobs = array();
		foreach ($entries as $entry) 
		{
			$department = $entry->previousSibling->previousSibling->nodeValue;
			$li = $xpath->query('li',$entry);
		
			foreach ($li as $job) 
			{
				$this_job = array();
				$this_job['department'] = $department;

				$a = $xpath->query('a',$job);
				$href = $a->item(0)->getAttribute('href');
				$title = $a->item(0)->nodeValue;
				$this_job['title'] = $title; 
				$this_job['url'] = $baseurl."/".$href;

				$details = jobDetails($this_job['url']);

				$jobs[] = $this_job;		

			}
		}
	}

	print_r($jobs);
}

function jobDetails($link) 
{
	$details = array();

	return $details();
}

main($html);
?>
