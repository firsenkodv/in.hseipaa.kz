<?php
use Diglactic\Breadcrumbs\Breadcrumbs;

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Главная', route('home'));
});
// Home > Contacts
Breadcrumbs::for('contacts', function ($trail) {
    $trail->parent('home');
    $trail->push((config2('moonshine.contact.title'))?:' - ', route('contacts'));
});

// Home > Company > Categories
Breadcrumbs::for('company_categories', function ($trail) {
    $trail->parent('home');
    $trail->push((config2('moonshine.company.title'))?:' - ' , route('company_categories'));
});

// Home > Company > Category
Breadcrumbs::for('company_category', function ($trail, $category) {
    $trail->parent('company_categories');
    $trail->push($category->title , route('company_category', ['category_slug' => $category->slug]));

});
// Home > Company > Category > Item
Breadcrumbs::for('company_item', function ($trail, $category, $item) {
    $trail->parent('company_category', $category);
    $trail->push($item->title , route('company_item', ['category_slug' => $category->slug, 'item_slug' => $item->slug]));
});

// Home
Breadcrumbs::for('search', function ($trail) {
    $trail->parent('home');

    $trail->push('Поиск', route('search'));
});
// Home > News
Breadcrumbs::for('site_new_categories', function ($trail) {
    $trail->parent('home');
    $trail->push((config2('moonshine.new.title'))?:' - ' , route('site_new_categories'));
});

// Home > News > Categories
Breadcrumbs::for('site_new_category', function ($trail, $category) {
    $trail->parent('site_new_categories');
    $trail->push($category->title , route('site_new_category', ['category_slug' => $category->slug]));
});

// Home > News > Categories >Item
Breadcrumbs::for('site_new_item', function ($trail, $category, $item) {
    $trail->parent('site_new_category', $category);
    $trail->push($item->title , route('site_new_item', ['category_slug' => $category->slug, 'item_slug' => $item->slug]));
});

// Home > RegistrySpecialists
Breadcrumbs::for('registry_specialists', function ($trail) {
    $trail->parent('home');
    $trail->push(\App\Enums\User\RegistryStatus::SPECIALIST->text(), route('registry_specialists'));
});

// Home > RegistrySpecialists > RegistrySpecialist
Breadcrumbs::for('registry_specialist', function ($trail, $item) {
    $trail->parent('registry_specialists');
    $trail->push($item->username);
});

// Home > RegistryExperts
Breadcrumbs::for('registry_experts', function ($trail) {
    $trail->parent('home');
    $trail->push(\App\Enums\User\RegistryStatus::EXPERT->text(), route('registry_experts'));
});

// Home > RegistryExperts > RegistryExpert
Breadcrumbs::for('registry_expert', function ($trail, $item) {
    $trail->parent('registry_experts');
    $trail->push($item->username);
});

// Home > RegistryLegalEntities
Breadcrumbs::for('registry_legal_entities', function ($trail) {
    $trail->parent('home');
    $trail->push(\App\Enums\User\RegistryStatus::LEGALENTITY->text(), route('registry_legal_entities'));
});

// Home > RegistryLegalEntities > RegistryLegalEntity
Breadcrumbs::for('registry_legal_entity', function ($trail, $item) {
    $trail->parent('registry_legal_entities');
    $trail->push($item->username);
});

// Home > Useful
Breadcrumbs::for('useful_section', function ($trail, $section) {
    $trail->parent('home');
    $trail->push($section->title , route('useful_section', $section->slug));
});

// Home > Useful > Category
Breadcrumbs::for('useful_category', function ($trail, $section, $category) {
    $trail->parent('useful_section', $section);
    $trail->push($category->title , route('useful_category', ['useful' => $section->slug ,'category_slug' => $category->slug]));
});

// Home > Useful > Category > Subcategory
Breadcrumbs::for('useful_subcategory', function ($trail, $section, $category, $subcategory) {
    $trail->parent('useful_category', $section, $category);
    $trail->push($subcategory->title , route('useful_subcategory', ['useful' => $section->slug ,'category_slug' => $category->slug, 'subcategory_slug' => $subcategory->slug]));
});


// Home > Useful > Category > Subcategory >item
Breadcrumbs::for('useful_item', function ($trail, $section, $category, $subcategory, $item) {
    $trail->parent('useful_subcategory', $section, $category, $subcategory);
    $trail->push($item->title , route('useful_item', ['useful' => $section->slug ,'category_slug' => $category->slug, 'subcategory_slug' => $subcategory->slug, 'item_slug' => $item->slug]));
});


// Home > Service
Breadcrumbs::for('service_section', function ($trail, $section) {
    $trail->parent('home');
    $trail->push($section->title , route('service_section', $section->slug));
});

// Home > Service > Category
Breadcrumbs::for('service_category', function ($trail, $section, $category) {
    $trail->parent('service_section', $section);
    $trail->push($category->title , route('service_category', ['service' => $section->slug ,'category_slug' => $category->slug]));
});

// Home > Service > Category  >item
Breadcrumbs::for('service_item', function ($trail, $section, $category, $item) {
    $trail->parent('service_category', $section, $category);
    $trail->push($item->title , route('service_item', ['service' => $section->slug ,'category_slug' => $category->slug,  'item_slug' => $item->slug]));
});

// Home > Tax
Breadcrumbs::for('tax_calendar', function ($trail, $item) {
    $trail->parent('home');
    $trail->push($item->title , route('tax_calendar', ['item_slug' => $item->slug]));
});

// Home > Mzps
Breadcrumbs::for('mzp_items', function ($trail) {
    $trail->parent('home');
    $trail->push((config2('moonshine.setting.mzp_page_title'))??' - ' , route('mzp_items'));
});

// Home > Mzps > Mzp
Breadcrumbs::for('mzp_item', function ($trail, $item) {
    $trail->parent('mzp_items');
    $trail->push($item->title , route('mzp_item', ['item_slug' => $item->slug]));
});

// Home > Login
Breadcrumbs::for('login', function ($trail) {
    $trail->parent('home');
    $trail->push('Вход' , route('login'));
});

// Home > CabinetUser
Breadcrumbs::for('cabinet_user', function ($trail) {
    $trail->parent('home');
    $trail->push('Кабинет' , route('cabinet_user'));
});

// Home > CabinetRop
Breadcrumbs::for('cabinet_rop', function ($trail) {
    $trail->parent('home');
    $trail->push('Кабинет РОП' , route('cabinet_rop'));
});

// Home > CabinetRop
Breadcrumbs::for('cabinet_update_personal_data_rop', function ($trail) {
    $trail->parent('cabinet_rop');
    $trail->push('Редактирование личных данных РОП' , route('cabinet_update_personal_data_rop'));
});

// Home > CabinetRop -> Managers
Breadcrumbs::for('rop_managers', function ($trail) {
    $trail->parent('cabinet_rop');
    $trail->push('Ваши менеджеры' , route('rop_managers'));
});

// Home > CabinetRop -> Managers > Manager
Breadcrumbs::for('rop_update_manager', function ($trail, $item) {
    $trail->parent('rop_managers');
    $trail->push('Менеджер - ' . $item->username  , route('rop_update_manager', $item->id));
});

// Home > CabinetRop -> Users
Breadcrumbs::for('rop_users', function ($trail) {
    $trail->parent('cabinet_rop');
    $trail->push('Ваши пользователи' , route('rop_users'));
});

// Home > CabinetRop -> Users -> User
Breadcrumbs::for('rop_update_user', function ($trail, $item) {
    $trail->parent('rop_users');
    $trail->push('Пользователь - ' . $item->username  , route('rop_update_user', $item->id));
});
