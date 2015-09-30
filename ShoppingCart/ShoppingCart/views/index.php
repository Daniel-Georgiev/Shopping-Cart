<?php //\Framework\ViewHelpers\Input::create()->setType("password")->addAttribute("placeholder", 'qweqwe')->render();
        \Framework\ViewHelpers\Form::create()
            ->setMethod('POST')
            ->addAttribute('name', 'Test')
            ->addAttribute("action", "wwww")
            ->addInput('text')
            ->addInput('password')
            ->render();