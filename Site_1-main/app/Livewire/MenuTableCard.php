<?php
//
//namespace App\Livewire;
//
//use App\Models\Dish;
//use App\Models\Menu_dish;
//use Livewire\Component;
//
//class MenuTableCard extends Component
//{
//    public $menu_id;
//    public $dish_id;
//    public $dish;
//
//    public function render()
//    {
//        $thisMenu = Menu::all();
//        $menus = Menu::all();
//        $dish = Dish::all();
////        $thisMenuDish = Menu_dish::where('menu_id', 1)
//        $thisMenuDish = Menu_dish::where('menu_id', 'like', "%{$this->menu_id}%")
//            ->get();
//        $thisDishName = Dish::where('id', 'like', "%{$this->dish_id}%")
//            ->get();
//        return view('livewire.menu-table-card', compact('thisMenuDish', 'thisDishName', 'dish', 'menus', 'thisMenu'));
//    }
//}
