<?php
class B2bController extends BaseController
{
    public function index(): void
    {
        $seo = (new SeoHelper())->forB2b();
        $this->render('pages/b2b', [
            'seo'           => $seo,
            'title'         => $seo->getTitle(),
            'objectTypes'   => B2bLead::objectTypes(),
            'interests'     => B2bLead::interestOptions(),
            'volumeOptions' => B2bLead::volumeOptions(),
            'success'       => flashGet('b2b_success'),
            'error'         => flashGet('b2b_error'),
        ]);
    }

    public function submit(): void
    {
        if (!csrfVerify()) {
            flashSet('b2b_error', 'Ошибка безопасности, попробуйте ещё раз');
            redirect('/b2b');
        }

        $company = trim($_POST['company'] ?? '');
        $name    = trim($_POST['name']    ?? '');
        $phone   = trim($_POST['phone']   ?? '');

        if (!$company || !$name || !$phone) {
            flashSet('b2b_error', 'Заполните обязательные поля: компания, имя и телефон');
            redirect('/b2b');
        }

        // Собираем чекбоксы интересов
        $interests = [];
        foreach (array_keys(B2bLead::interestOptions()) as $key) {
            if (!empty($_POST['interest_' . $key])) {
                $interests[] = $key;
            }
        }

        (new B2bLead())->create([
            'company'     => $company,
            'name'        => $name,
            'phone'       => $phone,
            'email'       => trim($_POST['email']       ?? ''),
            'object_type' => trim($_POST['object_type'] ?? ''),
            'interests'   => $interests,
            'volume'      => trim($_POST['volume']      ?? ''),
            'comment'     => trim($_POST['comment']     ?? ''),
        ]);

        Mailer::newB2bLead($lead);
        flashSet('b2b_success', 'Заявка принята! Наш менеджер свяжется с вами в течение рабочего дня.');
        redirect('/b2b#form');
    }
}
