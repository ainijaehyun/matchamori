<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    // Menampilkan daftar alamat customer
    public function index()
    {
        $addresses = Auth::user()
            ->addresses()
            ->latest()
            ->get();

        return view('customers.addresses.index', compact('addresses'));
    }

    // Menyimpan alamat baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_default' => 'nullable|boolean',
        ]);

        $validated['address'] = $this->normalizeAddress(
            $validated['address']
        );

        $user = Auth::user();

        $isFirstAddress = !$user->addresses()->exists();
        $isDefault = $isFirstAddress || $request->boolean('is_default');

        DB::transaction(function () use ($user, $validated, $isDefault) {

            if ($isDefault) {
                $user->addresses()->update([
                    'is_default' => false,
                ]);
            }

            $address = $user->addresses()->create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'postal_code' => $validated['postal_code'] ?? null,
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
                'is_default' => $isDefault,
            ]);

            // Sinkronkan alamat utama ke tabel users.
            if ($isDefault) {
                $user->update([
                    'name' => $address->name,
                    'phone' => $address->phone,
                    'address' => $address->address,
                ]);
            }
        });

        return back()->with('success', 'Alamat berhasil disimpan.');
    }

    public function edit($id)
    {
        $address = Auth::user()
            ->addresses()
            ->findOrFail($id);

        return view('customers.addresses.edit', compact('address'));
    }

    public function update(Request $request, $id)
    {
        $address = Auth::user()
            ->addresses()
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_default' => 'nullable|boolean',
        ]);

        $validated['address'] = $this->normalizeAddress(
            $validated['address']
        );

        $isDefault = $request->boolean('is_default');

        DB::transaction(function () use (
            $address,
            $validated,
            $isDefault
        ) {

            if ($isDefault) {
                $address->user->addresses()->update([
                    'is_default' => false,
                ]);
            }

            $address->update([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'postal_code' => $validated['postal_code'] ?? null,
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
                'is_default' => $isDefault,
            ]);

            // Jika alamat ini menjadi alamat utama,
            // perbarui juga data pada tabel users.
            if ($isDefault) {
                $address->user->update([
                    'name' => $address->name,
                    'phone' => $address->phone,
                    'address' => $address->address,
                ]);
            }
        });

        return redirect()->back()->with('success', 'Alamat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $address = Auth::user()
            ->addresses()
            ->findOrFail($id);

        DB::transaction(function () use ($address) {

            $wasDefault = $address->is_default;
            $user = $address->user;

            $address->delete();

            // Jika alamat utama dihapus,
            // jadikan alamat terbaru sebagai alamat utama.
            if ($wasDefault) {
                $newDefault = $user->addresses()
                    ->latest()
                    ->first();

                if ($newDefault) {
                    $newDefault->update([
                        'is_default' => true,
                    ]);
                }
            }
        });

        return back()->with('success', 'Alamat berhasil dihapus.');
    }

    // Membersihkan alamat yang memiliki wilayah berulang.
    private function normalizeAddress(string $address): string
    {
        $parts = array_values(array_filter(
            array_map('trim', explode(',', $address)),
            fn ($part) => $part !== ''
        ));

        while (count($parts) >= 8) {

            $previousRegion = array_map(
                fn ($item) => mb_strtolower(
                    preg_replace('/\s+/', ' ', $item)
                ),
                array_slice($parts, -8, 4)
            );

            $lastRegion = array_map(
                fn ($item) => mb_strtolower(
                    preg_replace('/\s+/', ' ', $item)
                ),
                array_slice($parts, -4, 4)
            );

            if ($previousRegion === $lastRegion) {
                array_splice($parts, -4);
            } else {
                break;
            }
        }

        return implode(', ', $parts);
    }
}
