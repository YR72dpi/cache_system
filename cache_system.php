<?php

// Inspired by the cache class of grafikart

class cache {

	public $duration;  // life duration of the file on minute
	public $file_name; // name file
	public $dir_name;  // Dossier dans le quel vous allez mettre le dossier temporaire où il y aurai le fichier
	public $buffer;    // Si le ob_start doit etre fait ou non

	public function __construct(string $dirname, string $filename, int $duration){
		$this->duration = $duration;
		$this->dir_name = $dirname.'/tmp/';
		$this->filename = str_replace(" ", '_', $filename).'.tmp';
		if (!file_exists($this->dir_name)) {
			mkdir($this->dir_name);
		}
	}

	/**
	 * write something in a file
	 * @param  string
	 * @return boolean
	 */
	public function write(string $content) {
		return file_put_contents($this->dir_name.$this->filename, $content);
	}

	/**
	 * return the file content or false if :
	 * - the file doesn't exist
	 * - the duration is <= 0
	 * - the lifetime > the duration
	 * @return boolean or string
	 */
	public function read(){

		$file = $this->dir_name.$this->filename;
		if (!file_exists($file)) {
			return false;
		}

		if ($this->duration <= 0) {
			return false;
		}

		$lifetime = (time() - filemtime($file)) / 60;
		if ($lifetime < $this->duration) {
			return file_get_contents($file);
		} else {
			return false;
		}
		
	}

	/**
	 * delete the tempory file
	 * @return true if it's ok or false if the file doesn't exist
	 */
	public function delete_file(){
		$file = $this->dir_name.$this->filename;
		if (file_exists($file)) {
			unlink($file);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * dellete all files in the tempory path
	 * @return null
	 */
	public function clear_dir(){
		$files = glob($this->dir_name.'/*');
		foreach ($files as $file) {
			unlink($file);
		}
	}

	public function start () {
		if ($content = $this->read()) {
			echo $content;
			$this->buffer = false;
			return true;
		}
		$file = $this->dir_name.$this->filename;
		ob_start();
		$this->buffer = $file;
	}

	public function end($auto_read = true){
		if (!$this->buffer) {
			return false;
		}
		$content = ob_get_clean();
		$this->write($content);
		if ($auto_read) {
			echo $content;
		}
	}


}



/* $cache = new cache(dirname(__FILE__), "re test", 1);

if (!$cache->start()) {
	sleep(1);
	$var = "SE <br>";
	echo $var;
	$var = "veux pas mbbangerbbbbbbbbbb <br>";
	echo $var;
	$var = microtime();
	echo $var;
} $cache->end(); */


//$cache->write("lol test 4");

/*if (!$variable = $cache->read()) {
	sleep(1);
	$variable = mt_rand(100, 9999)." _ ".mt_rand(1000, 9999);
	$cache->write($variable);
}

echo $variable;*/

/* $timestamp_debut = microtime(true);
$timestamp_fin = microtime(true);
$difference_ms = $timestamp_fin - $timestamp_debut;
echo '<p>Exécution du script : <span style="background-color: rgba(146, 146, 146, 0.3); padding: 0 5 0 5;">' . round($difference_ms, 3) . '</span> secondes.</p>'; */