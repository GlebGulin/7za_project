<?php
    $this->moduleTpl = "CMS/articles/index.tpl.html";

    $article_id = $this->getParam("GET", "article_id", "int");

    $Articles = $this->getClassOf("Articles");
    
    $id = $this->getParam("GET", "category_id", "int");
    $this->tpl->assign('curr_a_category', $id);
    $this->tpl->assign('articles_categories', $Articles->getCategories());

    if ( $article_id )
    {
        $this->contentFile = "CMS/articles/view.tpl.html";
        $article = $Articles->getArticleById($article_id);
        $this->tpl->assign('curr_a_category', $article['category_id']);
        if ( !$article || !$article["visible"] )
            $this->redirect("/pages/4/");

        $this->tpl->assign("article", $article);
        $this->pageTitle = $article["title"];
        //$Articles->articlesPerPage = 5;
        //$this->tpl->assign("other_articles", $Articles->getArticlesForFrontend($article_id));
    }
    else
    {
        if ($id) {
            $this->tpl->assign( "articles", $Articles->getArticlesForFrontendPage("/pages/4/", $id) );
            $this->tpl->assign( "splitMenu", $Articles->sm->makeLinkMenu() );
        } else {
            $this->tpl->assign( "articles", $Articles->getLastArticles(20));
        }
    }

?>