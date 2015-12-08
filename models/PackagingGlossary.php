<?php
class PackagingGlossary extends ActiveRecord\Model
{
	static $table_name = "packaging_glossary";
	static $primary_key = "term_id";
	static $connection = 'production';
}

?>
