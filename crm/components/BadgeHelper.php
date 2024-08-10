<?php

namespace app\components;

use yii\helpers\Html;

class BadgeHelper
{
    public static function getRoleBadge($role)
    {
        switch ($role) {
            case 'Admin':
                return '<span class="badge bg-primary-subtle text-primary-emphasis rounded-pill">Администратор</span>';
            case 'TeamLeadMediabuyer':
                return '<span class="badge bg-info-subtle text-info-emphasis rounded-pill">Тимлид медиабайеров</span>';
            case 'TeamLeadProcessor':
                return '<span class="badge bg-info-subtle text-info-emphasis rounded-pill">Тимлид обработчиков</span>';
            case 'Mediabuyer':
                return '<span class="badge bg-success-subtle text-success-emphasis rounded-pill">Медиабайер</span>';
            case 'Processor':
                return '<span class="badge bg-success-subtle text-success-emphasis rounded-pill">Обработчик</span>';
            case 'Financial':
                return '<span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">Финансист</span>';
            default:
                return Html::encode($role);
        }
    }

    public static function getStatusBadge($status)
    {
        switch ($status) {
            case 'active':
                return '<span class="badge bg-success-subtle text-success-emphasis rounded-pill">Аккаунт активирован</span>';
            case 'blocked':
                return '<span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">Аккаунт заблокирован</span>';
            case 'inactive':
                return '<span class="badge bg-warning-subtle text-warning-emphasis rounded-pill">Аккаунт неактивен</span>';
            case 'deleted':
                return '<span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">Аккаунт удален</span>';
            default:
                return Html::encode($status);
        }
    }
}