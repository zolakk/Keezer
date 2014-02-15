<?PHP
function isPidRunning($pid)
{
	exec("ps -p $pid", $output);
	if (count($output) > 1) {
	 return true;
	}
	else
	{
	return false;
	}
}
?>