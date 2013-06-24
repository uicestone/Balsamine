<form method="post">
<div class="inputTable">
    <div class="item">
        <div class="title"><label>标题：</label></div>
        <input name="news[title]" value="<? displayPost('news/title'); ?>" type="text" style="width:70%" />
    </div>

    <div class="item">
        <div class="title"><label>内容：</label></div>
        <textarea name="news[content]" rows="10" style="width:70%"><? displayPost('news/content'); ?></textarea>
    </div>

    <div class="submit">
        <input type="submit" name="newsSubmit" value="保存" />
        <input type="submit" name="unsetPost" value="取消" />
    </div>
</div>
</form>
<script type="text/javascript">
	$('[name="query[type]"]').val('<? displayPost('query/type'); ?>');
</script>