<?php
	
	use Illuminate\Database\Seeder;
	use TCG\Voyager\Models\Menu;
	use TCG\Voyager\Models\MenuItem;
	
	class FSLogMenuItemSeeder extends Seeder{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run(){
			$menu = Menu::where('name', 'admin')->firstOrFail();
			
			/*$menuItem = MenuItem::firstOrNew([
				'menu_id' => $menu->id,
				'title'   => 'FoodApp',
				'url'     => '/admin/foodapp',
			]);
			if (!$menuItem->exists) {
				$menuItem->fill([
					'target'     => '_self',
					'icon_class' => 'voyager-data',
					'color'      => '#fc6377',
					'parent_id'  => null,
					'order'      => 2,
				])->save();
			}*/
			
			
			$foodStudyMenuItem = MenuItem::firstOrNew(
				[
					'menu_id' => $menu->id,
					'title'   => 'FoodApp',
					'url'     => null,
					'route'   => null,
				]
			);
			if( !$foodStudyMenuItem->exists ){
				$foodStudyMenuItem->fill(
					[
						'target'     => '_self',
						'icon_class' => 'voyager-milestone',
						'color'      => '#fc6377',
						'parent_id'  => null,
						'order'      => 1,
					]
				)->save()
				;
			}
			
			
			
			$menuItem = MenuItem::firstOrNew(
				[
					'menu_id' => $menu->id,
					'title'   => 'Studies',
					'url'     => '/admin/foodapp/studies',
					'route'   => null,
				]
			);
			if( !$menuItem->exists ){
				$menuItem->fill(
					[
						'target'     => '_self',
						'icon_class' => 'voyager-lighthouse',
						'color'      => null,
						'parent_id'  => $foodStudyMenuItem->id,
						'order'      => 50,
					]
				)->save()
				;
			}
			
			
			
			
			$menuItem = MenuItem::firstOrNew(
				[
					'menu_id' => $menu->id,
					'title'   => 'Logs',
					'url'     => '/admin/foodapp/logs',
					'route'   => null,
				]
			);
			if( !$menuItem->exists ){
				$menuItem->fill(
					[
						'target'     => '_self',
						'icon_class' => 'voyager-logbook',
						'color'      => '#fc6377',
						'parent_id'  => $foodStudyMenuItem->id,
						'order'      => 51,
					]
				)->save()
				;
			}
			
			
			
			
			
			$menuItem = MenuItem::firstOrNew(
				[
					'menu_id' => $menu->id,
					'title'   => 'BLS Liste',
					'url'     => null,
					'route'   => 'voyager.fs-bls.index',
				]
			);
			if( !$menuItem->exists ){
				$menuItem->fill(
					[
						'target'     => '_self',
						'icon_class' => 'voyager-data',
						'color'      => null,
						'parent_id'  => $foodStudyMenuItem->id,
						'order'      => 53,
					]
				)->save();
			}
			
			
		}
	}
