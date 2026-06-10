<?php
class AdminB2bController extends AdminBaseController
{
    public function index(): void
    {
        $this->requireAdmin();

        $leads = array_reverse((new B2bLead())->all());

        $filterStatus = $_GET['status'] ?? '';
        if ($filterStatus) {
            $leads = array_values(array_filter(
                $leads, fn($l) => $l['status'] === $filterStatus
            ));
        }

        $this->render('b2b_leads', [
            'title'        => 'B2B заявки — Админ',
            'leads'        => $leads,
            'filterStatus' => $filterStatus,
            'stats'        => $this->stats(),
        ]);
    }

    public function updateStatus(array $params): void
    {
        $this->requireAdmin();
        if (!csrfVerify()) { echo 'CSRF'; return; }

        $valid = ['new', 'contacted', 'qualified', 'closed'];
        $status = $_POST['status'] ?? '';
        if (in_array($status, $valid)) {
            (new B2bLead())->updateStatus($params['id'], $status);
        }

        header('Location: /admin/b2b'); exit;
    }
}
