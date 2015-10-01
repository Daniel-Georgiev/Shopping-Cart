<?php \Framework\ViewHelpers\Input::create()->setType("password")->addAttribute("placeholder", 'qweqwe')->render();
        \Framework\ViewHelpers\Form::create()
            ->setMethod('POST')
            ->addAttribute('name', 'Test')
            ->addAttribute("action", "wwww")
            ->addInput('text')
                ->getParent()
            ->addInput('password')
                ->getParent()
            ->addInput('radio')
                ->getParent()
            ->addInput('radio')
                ->getParent()
            ->addInput('checkbox')
                ->getParent()
            ->render();

//        \Framework\ViewHelpers\TextArea::create()->addAttribute("name", 'asdasd')->render();