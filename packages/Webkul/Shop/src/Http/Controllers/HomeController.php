<?php

namespace Webkul\Shop\Http\Controllers;

use Webkul\CMS\Models\ShopNotification;
use Webkul\Shop\Http\Controllers\Controller;
use Webkul\Core\Repositories\SliderRepository;

 class HomeController extends Controller
{
    /**
     * SliderRepository object
     *
     * @var \Webkul\Core\Repositories\SliderRepository
    */
    protected $sliderRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Core\Repositories\SliderRepository  $sliderRepository
     * @return void
    */
    public function __construct(SliderRepository $sliderRepository)
    {
        $this->sliderRepository = $sliderRepository;

        parent::__construct();
    }

    /**
     * loads the home page for the storefront
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $currentChannel = core()->getCurrentChannel();

        $currentLocale = core()->getCurrentLocale();

        $sliderData = $this->sliderRepository
          ->where('channel_id', $currentChannel->id)
          ->where('locale', $currentLocale->code)
          ->get()
          ->toArray();

        $notification = ShopNotification::where('deleted_at', 0)->where('display_flag', 1)->orderBy('updated_at', 'DESC')->first();

        return view($this->_config['view'], compact('sliderData', 'notification'));
    }

    /**
     * loads the home page for the storefront
     *
     * @return \Exception
     */
    public function notFound()
    {
        abort(404);
    }
}