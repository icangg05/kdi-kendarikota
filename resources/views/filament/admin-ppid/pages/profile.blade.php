<x-filament-panels::page>
	<div class="space-y-6">
		<header>
			<h1 class="text-2xl font-semibold tracking-tight">Form Profil</h1>
			<p class="text-sm text-muted-foreground">
				Perbarui informasi akun.
			</p>
		</header>

		<x-filament::card>
			<form wire:submit.prevent="update">
				{{ $this->form }}

				<div style="margin-top: 20px">
					<x-filament::button
						type="submit"
						wire:target="update"
						wire:loading.attr="disabled">
						<span wire:loading.remove wire:target="update">
							Simpan
						</span>
						<span wire:loading wire:target="update">
							Menyimpan...
						</span>
					</x-filament::button>
				</div>
			</form>
		</x-filament::card>
	</div>
</x-filament-panels::page>
