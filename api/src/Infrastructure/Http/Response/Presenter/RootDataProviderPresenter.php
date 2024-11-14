<?php

namespace Infrastructure\Http\Response\Presenter;

/**
 * If a Presenter implements that interface our GenericSerializableResponder will only expose and serialise the data returned by its
 * `getExposedRootData()` method instead of serialising and returning the whole Presenter.
 */
interface RootDataProviderPresenter
{
    /**
     * @return mixed
     */
    public function getExposedRootData();
}
