<?php

interface IFeedbackForm
{
    public function getName();

    public function getEmail();

    public function getTheme();

    public function getText();

    public function getPhone();

    public function getType();
}
