<?php

namespace Controller;

use Model\Phone;
use Model\Room;
use Model\Subscriber;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class PhoneController
{

    public function phones(Request $request): string
    {
        $query = Phone::query();

        if ($search = $request->get('search_field')) {
            $query->where('phone_number', 'LIKE', "%{$search}%");
        }

        $phones = $query->get();

        return new View('site.phones', ['phones' => $phones, 'request' => $request]);
    }

    public function create_phone(Request $request): string
    {
        $subscribers = Subscriber::all();
        $rooms = Room::all();

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'phone_number' => ['required', 'phone'],
                'room_id' => ['required'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
                'phone' => 'Поле :field должно содержать корректный номер телефона, пример: +7(999)123-45-67'
            ]);

            if ($validator->fails()) {
                return new View('site.create_phone', [
                    'errors' => $validator->errors(),
                    'subscribers' => $subscribers,
                    'rooms' => $rooms,
                    'old' => $request->all()
                ]);
            }

            if(!$request->get('subscriber_id')) {
                $request->set('subscriber_id', null);
            }

            if (Phone::create($request->all())) {
                app()->route->redirect('/phones');
            }
        }
        return (new View())->render('site.create_phone', ['subscribers' => $subscribers, 'rooms' => $rooms]);
    }

    public function attach_phone(Request $request): string
    {
        $subscribers = Subscriber::all();
        $phones = Phone::where('subscriber_id', null)->get();
        if ($request->method === 'POST') {
            $choicePhone = $request->get('phone_id');
            $choiceSubscriber = $request->get('subscriber_id');

            if(!$choiceSubscriber || !$choicePhone) {
                $error = 'Нет доступных абонентов или телефонов';
                return (new View())->render('site.attach_number', [
                    'subscribers' => $subscribers,
                    'phones' => $phones,
                    'error' => $error,
                ]);
            }
            $phone = Phone::find($request->phone_id);
            $subscriber = Subscriber::find($request->subscriber_id);

            $phone->update([
                'subscriber_id' => $subscriber->id,
            ]);

            app()->route->redirect('/phones');
        }

        return (new View())->render('site.attach_number', [
            'subscribers' => $subscribers,
            'phones' => $phones
        ]);
    }

    public function detach_phone($id, Request $request)
    {
        $phone = Phone::find($id);

        $phone->subscriber_id = null;
        $phone->save();

        app()->route->redirect('/phones');
    }
}