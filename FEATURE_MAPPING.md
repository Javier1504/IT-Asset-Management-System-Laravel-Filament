# Pemetaan Fitur ITAM ke Versi General Filament

| Area | Implementasi Filament |
|---|---|
| Dashboard ITAM | Dashboard + widgets KPI |
| Data pegawai | UserResource |
| Perusahaan/organisasi | CompanyResource |
| Unit/Tim | field `team` dan `job_family` pada User, label dibuat general sebagai Unit/Divisi |
| Sub-tim khusus | MatrixSubTeamResource + MembersRelationManager |
| Jenis aset | AssetTypeResource |
| Aset utama | AssetResource |
| Aset pengguna | EndUserAssetResource |
| Aset kantor | OfficeAssetResource |
| Server/host fisik | PhysicalHostAssetResource |
| Network device | NetworkAssetResource |
| Security peripheral | SecurityPeripheralResource |
| Pengajuan aset | AssetRequestResource |
| Perbaikan aset | AssetMaintenanceResource |
| Instalasi aset | AssetInstallationResource |
| Pemusnahan aset | AssetDisposalResource + ItemsRelationManager |
| Vendor | VendorResource |
| Permintaan penawaran | AssetOfferRequestResource + OffersRelationManager |
| Penawaran vendor | VendorOfferResource |
| Lisensi software | SoftwareLicenseResource |
| Sparepart | SparepartTypeResource, SparepartResource, SparepartMovementResource |
| Stock opname | StockOpnameResource + Teams/Users/Items relation manager |
| Generate item stock opname | StockOpnameService::generateItems() |
| Complete stock opname | StockOpnameService::complete() |
| Export CSV stock opname | StockOpnameExportController |
| Catatan internal | InternalNoteResource |
| Knowledge base | KnowledgeBaseCategoryResource, KnowledgeBaseArticleResource |
| Audit trail | AuditTrailResource + AuditTrailObserver |
