<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{   
    $breadcrumbs->push('Home', route(config('project.admin_route').'home.index')  );
});

// Home > About
Breadcrumbs::register('attributes', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Attributes', route(config('project.admin_route').'attribute.index'));
    
});

Breadcrumbs::register('create_attribute', function($breadcrumbs)
{
    $breadcrumbs->parent('attributes');
    $breadcrumbs->push('Create', '');    
});
Breadcrumbs::register('edit_attribute', function($breadcrumbs)
{
    $breadcrumbs->parent('attributes');
    $breadcrumbs->push('Edit', '');    
});

Breadcrumbs::register('category', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Category', route(config('project.admin_route').'category.index'));    
});
Breadcrumbs::register('edit_category', function($breadcrumbs)
{
    $breadcrumbs->parent('category');
    $breadcrumbs->push('Edit', route(config('project.admin_route').'category.index'));    
});
Breadcrumbs::register('forums', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('forums', route(config('project.admin_route').'forums.index'));    
});
Breadcrumbs::register('createforums', function($breadcrumbs)
{
    $breadcrumbs->parent('forums');
    $breadcrumbs->push('Create', "");
});
Breadcrumbs::register('editforums', function($breadcrumbs)
{
    $breadcrumbs->parent('forums');
    $breadcrumbs->push('View', "");    
});
Breadcrumbs::register('departments', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('departments', route(config('project.admin_route').'departments.index'));    
});

Breadcrumbs::register('createdepartments', function($breadcrumbs)
{
    $breadcrumbs->parent('departments');
    $breadcrumbs->push('Create', "");
});
Breadcrumbs::register('editdepartments', function($breadcrumbs)
{
    $breadcrumbs->parent('departments');
    $breadcrumbs->push('Edit', "");    
});

// File Uploads
Breadcrumbs::register('fileuploads', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('fileuploads', route(config('project.admin_route').'fileuploads.index'));    
});

Breadcrumbs::register('createfileuploads', function($breadcrumbs)
{
    $breadcrumbs->parent('fileuploads');
    $breadcrumbs->push('Create', "");
});
Breadcrumbs::register('editfileuploads', function($breadcrumbs)
{
    $breadcrumbs->parent('fileuploads');
    $breadcrumbs->push('Edit', "");    
});
// Labels
Breadcrumbs::register('labels', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('labels', route(config('project.admin_route').'labels.index'));    
});

Breadcrumbs::register('createlabels', function($breadcrumbs)
{
    $breadcrumbs->parent('labels');
    $breadcrumbs->push('Create', "");
});
Breadcrumbs::register('editlabels', function($breadcrumbs)
{
    $breadcrumbs->parent('labels');
    $breadcrumbs->push('Edit', "");    
});

// Labels
Breadcrumbs::register('donationvendors', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('DONATION VENDOR LIST', route(config('project.admin_route').'donationvendors.index'));    
});

Breadcrumbs::register('createdonationvendors', function($breadcrumbs)
{
    $breadcrumbs->parent('donationvendors');
    $breadcrumbs->push('Create', "");
});
Breadcrumbs::register('editdonationvendors', function($breadcrumbs)
{
    $breadcrumbs->parent('donationvendors');
    $breadcrumbs->push('Edit', "");    
});
/*
 *  Content Pages
 */
Breadcrumbs::register('contentPages', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Content Pages', route(config('project.admin_route').'content_pages.index'));    
});

Breadcrumbs::register('createContentPage', function($breadcrumbs)
{
    $breadcrumbs->parent('contentPages');
    $breadcrumbs->push('Create', "");
});
Breadcrumbs::register('editContentPage', function($breadcrumbs)
{
    $breadcrumbs->parent('contentPages');
    $breadcrumbs->push('Edit', "");    
});

/*
 *  Terms & Condition
 */
Breadcrumbs::register('termsAndConditions', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Terms & Conditions', route(config('project.admin_route').'terms_and_conditions.index'));    
});

Breadcrumbs::register('createTermAndCondition', function($breadcrumbs)
{
    $breadcrumbs->parent('termsAndConditions');
    $breadcrumbs->push('Create', "");
});
Breadcrumbs::register('editTermAndCondition', function($breadcrumbs)
{
    $breadcrumbs->parent('termsAndConditions');
    $breadcrumbs->push('Edit', "");    
});

/*
 *  FAQ Topic
 */
Breadcrumbs::register('faqTopics', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('FAQ Topics', route(config('project.admin_route').'faq.index'));    
});

Breadcrumbs::register('createFaq', function($breadcrumbs)
{
    $breadcrumbs->parent('faqTopics');
    $breadcrumbs->push('Create', "");
});
Breadcrumbs::register('editFaq', function($breadcrumbs)
{
    $breadcrumbs->parent('faqTopics');
    $breadcrumbs->push('Edit', "");    
});

/*
 *  Secret Questions
 */
Breadcrumbs::register('secretQuestions', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Secret Questions', route(config('project.admin_route').'secret_questions.index'));    
});

Breadcrumbs::register('createSecretQuestion', function($breadcrumbs)
{
    $breadcrumbs->parent('secretQuestions');
    $breadcrumbs->push('Create', "");
});
Breadcrumbs::register('editSecretQuestion', function($breadcrumbs)
{
    $breadcrumbs->parent('secretQuestions');
    $breadcrumbs->push('Edit', "");    
});

/*
 *  Newsletters
 */
Breadcrumbs::register('newsletters', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Newsletters', route(config('project.admin_route').'newsletters.index'));    
});

Breadcrumbs::register('createNewsletter', function($breadcrumbs)
{
    $breadcrumbs->parent('newsletters');
    $breadcrumbs->push('Create', "");
});
Breadcrumbs::register('editNewsletter', function($breadcrumbs)
{
    $breadcrumbs->parent('newsletters');
    $breadcrumbs->push('Edit', "");    
});

/*
 * Global Setting
 */
Breadcrumbs::register('manageGlobalSetting', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Manage Global Settings', "");
});
Breadcrumbs::register('giftcards', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Giftcards', route(config('project.admin_route').'giftcards.index'));    
});
Breadcrumbs::register('create_giftcards', function($breadcrumbs)
{
    $breadcrumbs->parent('giftcards');
    $breadcrumbs->push('Create', '');    
});
Breadcrumbs::register('edit_giftcards', function($breadcrumbs)
{
    $breadcrumbs->parent('giftcards');
    $breadcrumbs->push('Edit', '');    
});
Breadcrumbs::register('productConditions', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Product Conditions', route(config('project.admin_route').'product_conditions.index'));    
});
Breadcrumbs::register('create_productConditions', function($breadcrumbs)
{
    $breadcrumbs->parent('productConditions');
    $breadcrumbs->push('Create', '');    
});
Breadcrumbs::register('edit_productConditions', function($breadcrumbs)
{
    $breadcrumbs->parent('productConditions');
    $breadcrumbs->push('Edit', '');    
});
Breadcrumbs::register('occasions', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Occasions', route(config('project.admin_route').'occasions.index'));    
});
Breadcrumbs::register('create_occasions', function($breadcrumbs)
{
    $breadcrumbs->parent('occasions');
    $breadcrumbs->push('Create', '');    
});
Breadcrumbs::register('edit_occasions', function($breadcrumbs)
{
    $breadcrumbs->parent('occasions');
    $breadcrumbs->push('Edit', '');    
});
Breadcrumbs::register('promotions', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Promotions', route(config('project.admin_route').'promotions.index'));    
});
Breadcrumbs::register('create_promotions', function($breadcrumbs)
{
    $breadcrumbs->parent('promotions');
    $breadcrumbs->push('Create', '');    
});
Breadcrumbs::register('edit_promotions', function($breadcrumbs)
{
    $breadcrumbs->parent('promotions');
    $breadcrumbs->push('Edit', '');    
});



/*
 * Manage fees and commissions
 */
Breadcrumbs::register('manageCommissionFeesProducts', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Manage Commission & Fees (Services)', route('commissionFeesList', 'Services'));
    $breadcrumbs->push('Products', '');
});
Breadcrumbs::register('manageCommissionFeesServices', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Manage Commission & Fees (Products)', route('commissionFeesList', 'Products'));
    $breadcrumbs->push('Services', '');
});

Breadcrumbs::register('employees', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Employees', route(config('project.admin_route').'employee.index'));    
});
Breadcrumbs::register('create_employee', function($breadcrumbs)
{
    $breadcrumbs->parent('employees');
    $breadcrumbs->push('Create', '');    
});
Breadcrumbs::register('edit_employee', function($breadcrumbs)
{
    $breadcrumbs->parent('employees');
    $breadcrumbs->push('Edit', '');    
});

Breadcrumbs::register('modules', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Modules', route(config('project.admin_route').'module.index'));    
});
Breadcrumbs::register('create_module', function($breadcrumbs)
{
    $breadcrumbs->parent('modules');
    $breadcrumbs->push('Create', '');    
});
Breadcrumbs::register('edit_module', function($breadcrumbs)
{
    $breadcrumbs->parent('modules');
    $breadcrumbs->push('Edit', '');    
});

Breadcrumbs::register('levels', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Levels', route(config('project.admin_route').'level.index'));    
});
Breadcrumbs::register('create_level', function($breadcrumbs)
{
    $breadcrumbs->parent('levels');
    $breadcrumbs->push('Create Level', '');    
});
Breadcrumbs::register('edit_level', function($breadcrumbs)
{
    $breadcrumbs->parent('levels');
    $breadcrumbs->push('Edit Level', '');    
});


Breadcrumbs::register('products', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Products', route(config('project.admin_route').'products.index'));    
});
Breadcrumbs::register('create_products', function($breadcrumbs)
{
    $breadcrumbs->parent('products');
    $breadcrumbs->push('Create', '');    
});
Breadcrumbs::register('edit_products', function($breadcrumbs)
{
    $breadcrumbs->parent('products');
    $breadcrumbs->push('Edit', '');    
});


Breadcrumbs::register('messages', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Messages', route(config('project.admin_route').'messagelist.index'));    
});
Breadcrumbs::register('compose_message', function($breadcrumbs)
{
    $breadcrumbs->parent('messages');
    $breadcrumbs->push('Compose Message', '');    
});
Breadcrumbs::register('view_message', function($breadcrumbs)
{
    $breadcrumbs->parent('messages');
    $breadcrumbs->push('View Message', '');    
});

Breadcrumbs::register('countries', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Country', route(config('project.admin_route').'country.index'));    
});
Breadcrumbs::register('create_country', function($breadcrumbs)
{
    $breadcrumbs->parent('countries');
    $breadcrumbs->push('Create', '');    
});
Breadcrumbs::register('edit_country', function($breadcrumbs)
{
    $breadcrumbs->parent('countries');
    $breadcrumbs->push('Edit', '');    
});

Breadcrumbs::register('attributeset', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Attributeset', route(config('project.admin_route').'attributeset.index'));    
});
Breadcrumbs::register('create_attributeset', function($breadcrumbs)
{
    $breadcrumbs->parent('attributeset');
    $breadcrumbs->push('Create', '');    
});
Breadcrumbs::register('edit_attributeset', function($breadcrumbs)
{
    $breadcrumbs->parent('attributeset');
    $breadcrumbs->push('Edit', '');    
});

// Labels
Breadcrumbs::register('vendors', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Vendors', route(config('project.admin_route').'vendors.index'));    
});

Breadcrumbs::register('create_vendors', function($breadcrumbs)
{
    $breadcrumbs->parent('vendors');
    $breadcrumbs->push('Create', "");
});
Breadcrumbs::register('edit_vendors', function($breadcrumbs)
{
    $breadcrumbs->parent('vendors');
    $breadcrumbs->push('Edit', "");    
});
Breadcrumbs::register('create_transaction', function($breadcrumbs)
{
    $breadcrumbs->parent('vendors');
    $breadcrumbs->push('Create Transaction', "");    
});

/*
 * Users Management
 */
Breadcrumbs::register('users', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Users Management', route(config('project.admin_route').'users.index'));    
});
Breadcrumbs::register('editUsers', function($breadcrumbs)
{
    $breadcrumbs->parent('users');
    $breadcrumbs->push('Edit', "");    
});

/*
 * Email templates
 */
Breadcrumbs::register('emailTemplates', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Manage Email Templates', route(config('project.admin_route').'email_templates.index'));    
});
Breadcrumbs::register('editEmailTemplates', function($breadcrumbs)
{
    $breadcrumbs->parent('emailTemplates');
    $breadcrumbs->push('Edit', "");    
});

/*// Home > Blog
Breadcrumbs::register('blog', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Blog', route('blog'));
});

// Home > Blog > [Category]
Breadcrumbs::register('category', function($breadcrumbs, $category)
{
    $breadcrumbs->parent('blog');
    $breadcrumbs->push($category->title, route('category', $category->id));
});

// Home > Blog > [Category] > [Page]
Breadcrumbs::register('page', function($breadcrumbs, $page)
{
    $breadcrumbs->parent('category', $page->category);
    $breadcrumbs->push($page->title, route('page', $page->id));
});
*/