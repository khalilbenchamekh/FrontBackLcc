<?php


namespace App\Services\Load;

use App\Repository\Load\ILoadRepository;





class LoadService implements ILoadService
{
    private ILoadRepository $loadRepository;
    public function __construct(ILoadRepository $loadRepository)
    {
        $this->loadRepository=$loadRepository;
    }

        public function index($page)
        {
            return $this->loadRepository->index($page);

        }
        public function store($data)
        {
            return $this->loadRepository->store($data);
        }
        public function edit($load,$data)
        {
            return $this->loadRepository->edit($load,$data);
        }
        public function destroy($id)
        {
            return $this->loadRepository->destroy($id);
        }

        public function show($id)
        {
            // TODO: Implement show() method.
            return $this->loadRepository->show($id);
        }
}
