<div id="footy" class="clear span-24">
	<p class="quiet">
		このドキュメントは<a href="http://mootools.net">MooTools</a>のドキュメントを元に<a href="<?php echo $fumiki->root; ?>">高橋文樹</a>が翻訳（ちょっと改変）しました。<br />
		<a href="http://mootools.net/doc">本家</a>と同じく、<a href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Attribution-NonCommercial-ShareAlike 3.0</a>ライセンスで公表されています。
	</p>

</div><!--footy ends-->


</div><!--container ends-->

</div><!--wrapper ends-->


<div id="footer">
	<div class="container">
		<a class="copy" href="http://mad4milk.net" id="mucca"><span>Mad for Milk</span></a>
		<p>copyright &copy;2006-<?php echo date('Y'); ?> <a href="http://mad4milk.net">Valerio Proietti</a></p>
	</div><!--container ends-->
</div><!--footer ends-->
<?php if(is_single() && !is_single('294')): ?>
<a id="toTop" href="#wrapper"><span>トップに戻る</span></a>
<?php endif; ?>
<!-- Scripts -->
<script src="<?php echo $fumiki->template; ?>/js/mootools.js" type="text/javascript"></script>
<script src="<?php echo $fumiki->template; ?>/js/moo_searchbox.js" type="text/javascript"></script>
</body>
</html>