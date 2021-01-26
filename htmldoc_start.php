<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>Cyberpunk Red - Character Sheet Manager</title>
		
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta http-equiv="content-language" content="en">
	
		<meta name="author" content="PedroCosta/CrankyUnicorn">
		<meta name="keywords" content="Cyberpunk, Red, 2077, Character, Sheet, Creation, Utility, Util">
		<meta name="description" content="Cyberpunk Red - Character Sheet">
	
		<!-- ChracterCreator | CharacterSheet -->
		<meta name="DC.creator" content="CrankyUnicorn" lang="en">
		<meta name="DC.date.created" scheme="DCTERMS.W3CDTF" content="2021-01-7" lang="en">
		<meta name="DC.date.modified" scheme="DCTERMS.W3CDTF" content="2021-01-15" lang="en">
		<meta name="DC.description" content="TemplatePHP" lang="en">
		<meta name="DC.format" scheme="DCTERMS.IMT" content="text/html" lang="en">
		<meta name="DC.identifier" scheme="DCTERMS.URI" content="">
		<meta name="DC.language" scheme="DCTERMS.ISO639-1" content="en">
		<meta name="DC.publisher" content="CrankyUnicorn" lang="en">
		<meta name="DC.rights.copyright" content="CDPR" lang="en">
		<meta name="DC.title" content="Cyberpunk Red - Character Sheet Manager" lang="en">
		<meta name="DC.coverage" content="World" lang="en">
		<meta name="DC.subject" content="Self Service" lang="en">

				<link rel="icon" href="assets/icons/favicon.png">
				
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
        <link href="assets/styles/style.css" rel="stylesheet" type="text/css">

        <!-- hack to fix require() and export{} related errors when trasnpiling from TypeScript -->
        <script type="text/javascript">var exports = {};</script>
        
    </head>
    <body>
		
		<?php session_start(); ?>
		
		<?php include 'page_navbar.php'; ?>
