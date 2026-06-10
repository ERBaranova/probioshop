<?php
class B2bLead extends JsonModel
{
    protected string $file = DATA_B2B_LEADS;

    public function all(): array
    {
        return $this->readAll();
    }

    public function create(array $data): array
    {
        $lead = [
            'id'          => $this->generateId(),
            'company'     => trim($data['company']     ?? ''),
            'name'        => trim($data['name']        ?? ''),
            'phone'       => trim($data['phone']       ?? ''),
            'email'       => trim($data['email']       ?? ''),
            'object_type' => trim($data['object_type'] ?? ''),
            'interests'   => $data['interests'] ?? [],
            'volume'      => trim($data['volume']      ?? ''),
            'comment'     => trim($data['comment']     ?? ''),
            'status'      => 'new',  // new | contacted | qualified | closed
            'created_at'  => date('Y-m-d H:i:s'),
            'source'      => 'b2b_page',
        ];

        $all   = $this->readAll();
        $all[] = $lead;
        $this->writeAll($all);

        return $lead;
    }

    public function updateStatus(string $id, string $status): bool
    {
        $all = $this->readAll();
        foreach ($all as &$lead) {
            if ($lead['id'] === $id) {
                $lead['status'] = $status;
                $this->writeAll($all);
                return true;
            }
        }
        return false;
    }

    public static function statusLabel(string $status): string
    {
        return match($status) {
            'new'       => 'Новая',
            'contacted' => 'Контакт установлен',
            'qualified' => 'Квалифицирован',
            'closed'    => 'Закрыт',
            default     => $status,
        };
    }

    public static function objectTypes(): array
    {
        return [
            'horeca'    => 'Ресторан / HoReCa',
            'medical'   => 'Медучреждение',
            'hotel'     => 'Отель / санаторий',
            'cleaning'  => 'Клининговая компания',
            'agro'      => 'Агробизнес / ферма',
            'industry'  => 'Производство',
            'other'     => 'Другое',
        ];
    }

    public static function interestOptions(): array
    {
        return [
            'cleaning'  => 'Концентраты для уборки',
            'sanitary'  => 'Санитария и дезинфекция',
            'animals'   => 'Средства для животных',
            'water'     => 'Обработка водоёмов',
            'training'  => 'Обучение персонала',
        ];
    }

    public static function volumeOptions(): array
    {
        return [
            'small'  => 'До 50 литров/мес.',
            'medium' => '50–200 литров/мес.',
            'large'  => '200–500 литров/мес.',
            'xlarge' => 'Свыше 500 литров/мес.',
        ];
    }
}
