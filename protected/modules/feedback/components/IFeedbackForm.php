<?php

/**
 * Interface IFeedbackForm
 */
interface IFeedbackForm
{
    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getEmail();

    /**
     * @return mixed
     */
    public function getTheme();

    /**
     * @return mixed
     */
    public function getText();

    /**
     * @return mixed
     */
    public function getPhone();

    /**
     * @return mixed
     */
    public function getType();
}
